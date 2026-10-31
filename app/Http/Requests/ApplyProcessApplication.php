<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyProcessApplication extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'cv_id' => 'required_without:cv_file|nullable|exists:resumes,id',
            'cv_file' => 'required_without:cv_id|nullable|file|mimes:pdf|max:5120'
        ];
    }

    public function messages(): array
    {
        return [
            'cv_file.required' => 'Please upload your CV before submitting your application.',
            'cv_file.file'     => 'The uploaded CV could not be processed. Please try again.',
            'cv_file.mimes'    => 'Invalid file format. Please upload your CV as a PDF file.',
            'cv_file.max'      => 'Your CV exceeds the 5 MB limit. Please upload a smaller file.',
            'cv_id.required' => 'Please choose your CV before submitting your application.',
        ];
    }
}
