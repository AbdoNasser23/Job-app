<?php
namespace App\Http\Controllers;

use App\Http\Requests\ApplyProcessApplication;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\JobVacancyView;
use App\Models\Resume;
use App\Services\ResumeAnalysisServices;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VacancyController extends Controller
{
    public function show(JobVacancy $vacancy)
    {
        if (Auth::check()) {
            $view = JobVacancyView::firstOrCreate([
                'job_vacancy_id' => $vacancy->id,
                'user_id'        => Auth::id(),
            ]);

            if ($view->wasRecentlyCreated) {
                $vacancy->increment('view_count');
            }
        }

        return view('vacancy.show', compact('vacancy'));
    }

    public function apply(JobVacancy $vacancy)
    {
        $resumes = Auth::user()->resume;

        return view('vacancy.apply', compact('vacancy', 'resumes'));
    }

    public function processToApply(ApplyProcessApplication $request, JobVacancy $vacancy , ResumeAnalysisServices $resumeAnalysis)
    {
        $existingFile = $request->input('cv_id');
        $file         = $request->file('cv_file');

        if (! $existingFile) {
            // Upload CV to Cloudinary
            $extensions       = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName         = "resume_" . time() . ".$extensions";
            $this->uploadResume($file, $originalFileName, $fileName, $vacancy , $resumeAnalysis);
        } else {
            //select CV from CVs uploaded
            $this->selectResume($existingFile, $vacancy ,$resumeAnalysis);
        }



        return to_route('application.index')->with('success', 'Application submitted successfuly!');
    }

    // Upload CV to Cloudinary

    public function uploadResume(mixed $file, mixed $originalFileName, mixed $fileName, JobVacancy $vacancy , ResumeAnalysisServices $resumeAnalysis)
    {
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        $uploadedFile = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'resource_type' => 'raw',
                'folder'        => 'jobboard/cvs',
                'public_id'     => pathinfo($fileName, PATHINFO_FILENAME),
                'format'        => 'pdf',
            ]
        );


        $resume = Resume::create([
            'file_name'       => $originalFileName,
            'file_uri'        => $uploadedFile['secure_url'],
            'contact_details' =>
                "Name: " .  Auth::user()->name . "\n" .
                "Email: ". Auth::user()->email
                ,
            'user_id'         => Auth::id(),
            'skills'          => '',
            'summary'         => '',
            'experience'      => '',
            'education'       => '',
        ]);


        $this->storeResume($resume->id,$vacancy , $resumeAnalysis);
    }

    public function selectResume(mixed $file_id, JobVacancy $vacancy , ResumeAnalysisServices $resumeAnalysis)
    {
        $this->storeResume($file_id,$vacancy,$resumeAnalysis);
    }



    public function storeResume( mixed $file_id , JobVacancy $vacancy ,ResumeAnalysisServices $resumeAnalysis )
    {
        $resume = Resume::where('user_id' , Auth::id())->findorFail($file_id) ;

        $result = $resumeAnalysis->extractResumeInformation($resume->file_uri);
        $resume->update([
            'skills'          => $result['skills'] ?? '',
            'summary'         => $result['summary'] ??'',
            'experience'      => $result['experience'] ??'',
            'education'       => $result['education'] ??'',
        ]);

        $evalution = $resumeAnalysis->generateScoreAndFeedback($resume , $vacancy);


        JobApplication::create([
            'status'                => 'pending',
            'ai_generated_score'    => $evalution['ai_generated_score'],
            'ai_generated_feedback' => $evalution['ai_generated_feedback'],
            'job_vacancy_id'        => $vacancy->id,
            'resume_id'             => $file_id,
            'user_id'               => Auth::id(),
        ]);


    }



}
