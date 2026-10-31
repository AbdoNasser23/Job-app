<?php

namespace App\Services;

use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisServices
{
    public function extractResumeInformation(string $file_uri)
    {
        // extract text form the resume pdf file (read pdf file , get the text)
        $text     = $this->extractTextFromPdf($file_uri);
        $response = $this->groqAi($text);

        return $response;
    }

    private function groqAi(string $text): array
    {
        $prompt = "
    Analyze the following resume and extract its information.

    Return a valid JSON object with exactly these keys:
    - skills
    - summary
    - experience
    - education

    IMPORTANT:
    - Every value must be a plain string.
    - Do not return arrays or nested objects.
    - For skills, list the skills as a comma-separated string.
    - For experience, write the job title, company, dates,
        and responsibilities as readable text.
    - For education, write the degree, institution, and dates
        as readable text.
    - For summary, return a normal paragraph.
    - Use only information found in the resume.
    - Do not invent missing information.
    - If a field is unavailable, return an empty string.

    Resume text:
    {$text}
";
        try {

            $response = Http::withToken(config('services.groq.key'))->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'           => 'openai/gpt-oss-120b',
                    'messages'        => [
                        [
                            'role'    => 'system',
                            'content' => 'You are a resume analysis assistant. Extract accurate information from resumes and return a valid JSON object with exactly these keys: skills, summary, experience, education. Do not invent information that is not present in the resume.',
                        ],
                        [
                            'role'    => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'response_format' => [
                        'type' => 'json_object',
                    ],
                ]);

            $response->throw();

            $result = $response->json('choices.0.message.content');

            $data = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON returned by Groq.');
            }

            return $data;
        } catch (\Throwable $e) {
            throw new \RuntimeException("Error Processing Request", 1, $e);
        }
    }

    private function extractTextFromPdf(string $file_uri): string
    {
        $response = Http::timeout(30)->get($file_uri);
        $response->throw();

        $tempPath = storage_path('app/temp/' . Str::uuid() . '.pdf');

        File::ensureDirectoryExists(dirname($tempPath));

        try {

            $isSuccess = File::put($tempPath, $response->body());
            if ($isSuccess === false) {
                throw new \RuntimeException('Failed to write temporary PDF file.');
            }

            return Pdf::getText($tempPath);
        } finally {
            File::delete($tempPath);
        }
    }


    public function generateScoreAndFeedback(Resume $resume, JobVacancy $vacancy): array
    {
        $prompt = "
    Evaluate how well the following resume matches the job vacancy.

    Resume information:
    Skills: {$resume->skills}
    Summary: {$resume->summary}
    Experience: {$resume->experience}
    Education: {$resume->education}

    Job information:
    Title: {$vacancy->title}
    Description: {$vacancy->description}
    Type: {$vacancy->type}
    Location: {$vacancy->location}

    Evaluate the candidate based only on the provided information.

    Scoring guidelines:
    - Return a score between 0 and 100.
    - Consider relevant skills, experience, education, and job requirements.
    - Give higher scores when the candidate's qualifications closely match
      the job requirements.
    - Do not assume the candidate has skills or experience not mentioned
      in the resume.
    - Do not penalize missing information as proof that the candidate
      lacks a qualification.
    - The score represents job relevance, not a hiring decision.

    Feedback guidelines:
    - Explain why the resume matches or does not match the vacancy.
    - Mention the candidate's relevant strengths.
    - Identify missing or unclear requirements, if any.
    - Suggest areas for improvement when appropriate.
    - Write the feedback in clear, professional English.
    - Return the feedback as a plain string, not an array or object.

    Output requirements:
    - Return a valid JSON object with exactly these two keys:
      1. ai_generated_score: an integer between 0 and 100.
      2. ai_generated_feedback: a plain string explaining the evaluation.
    - Do not return arrays or nested objects.
    - Do not include Markdown or additional keys.
    - Ensure the response is valid JSON.

";
        try {

            $response = Http::withToken(config('services.groq.key'))->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'           => 'openai/gpt-oss-120b',
                    'messages'        => [
                        [
                            'role'    => 'system',
                            'content' => 'You are a resume-to-job matching assistant. Evaluate relevance fairly using only the provided information. Return valid JSON with exactly these keys: ai_generated_score and ai_generated_feedback.',
                        ],
                        [
                            'role'    => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'response_format' => [
                        'type' => 'json_object',
                    ],
                ]);

            $response->throw();

            $result = $response->json('choices.0.message.content');

            $data = json_decode($result, true);

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($data) ||
                !isset($data['ai_generated_score'], $data['ai_generated_feedback']) ||
                !is_numeric($data['ai_generated_score']) ||
                !is_string($data['ai_generated_feedback'])
            ) {
                throw new \RuntimeException('Invalid score and feedback returned by Groq.');
            }

            $score = (int) $data['ai_generated_score'];

            if ($score < 0 || $score > 100) {
                throw new \RuntimeException('The generated score must be between 0 and 100.');
            }

            return [
                'ai_generated_score' => $score,
                'ai_generated_feedback' => $data['ai_generated_feedback'],
            ];
        } catch (\Throwable $e) {
            throw new \RuntimeException("Error Processing Request", 1, $e);
        }
    }
}
