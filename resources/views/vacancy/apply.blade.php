@extends('layouts.app')

@section('title', 'Apply for Job - JobBoard')

@section('content')
    @php
        $hasCvError = $errors->has('cv_file');
        $hasCvIdError = $errors->has('cv_id');
    @endphp

    <div class="min-h-screen bg-[#050816] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">

            {{-- Back Navigation --}}
            <a href="{{ url('/dashboard') }}"
                class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-400 transition hover:text-indigo-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5m7 7-7-7 7-7" />
                </svg>
                Back to jobs
            </a>

            <div class="grid items-start gap-6 lg:grid-cols-3">

                {{-- Application Form --}}
                <div class="min-w-0 lg:col-span-2">
                    <div
                        class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#080d1d] shadow-2xl shadow-black/10">

                        {{-- Header --}}
                        <div class="border-b border-white/[0.08] p-6 sm:p-8">
                            <span
                                class="inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-500/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-indigo-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                                JOB APPLICATION
                            </span>

                            <h1 class="mt-4 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                                Apply for this position
                            </h1>

                            <p class="mt-3 max-w-xl text-sm leading-6 text-slate-400">
                                Submit your application using an existing CV or upload a new one.
                                Make sure your resume is ready before applying.
                            </p>
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('vacancy.processToApply', $vacancy->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-8 p-6 sm:p-8">

                            @csrf

                            {{-- Select Existing CV --}}
                            <div>
                                <div class="mb-4 flex items-start justify-between gap-3">
                                    <div>
                                        <h2 class="text-base font-semibold text-white">
                                            Choose your CV
                                        </h2>
                                        <p class="mt-1 text-sm leading-5 text-slate-500">
                                            Select a resume you've uploaded previously.
                                        </p>
                                    </div>

                                    <span
                                        class="shrink-0 rounded-lg border border-white/10 bg-white/[0.03] px-2.5 py-1 text-xs font-medium text-slate-400">
                                        PDF only
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="relative min-w-0 flex-1">
                                    <select name="cv_id" id="cv_id"
                                        aria-invalid="{{ $hasCvIdError ? 'true' : 'false' }}"
                                        class="w-full appearance-none rounded-xl border bg-[#050816] px-4 py-3.5 pr-11 text-sm text-white outline-none transition focus:ring-2
                                    {{ $hasCvIdError
                                        ? 'border-rose-400/60 focus:border-rose-400 focus:ring-rose-500/10'
                                        : 'border-white/10 focus:border-indigo-400/50 focus:ring-indigo-500/10' }}">


                                        <option value="" selected disabled class="bg-[#080d1d]">
                                            Select an existing CV
                                        </option>

                                        @foreach ($resumes as $resume)
                                            <option value="{{ $resume->id }}" class="bg-[#080d1d]">
                                                {{ $resume->file_name}} - {{ $resume->updated_at->format('d/m/Y h:i A') }}
                                            </option>
                                        @endforeach

                                        {{-- Add your saved CV options here --}}
                                    </select>

                                    <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="m7 10 5 5 5-5" />
                                    </svg>
                                    </div>

                                    <button type="button" id="clear-cv-select" disabled
                                        class="shrink-0 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3.5 text-sm font-semibold text-slate-400 transition hover:border-rose-400/30 hover:bg-rose-500/10 hover:text-rose-300 disabled:cursor-not-allowed disabled:opacity-40">
                                        Clear
                                    </button>
                                </div>

                                {{-- CV Selection Error --}}
                                @error('cv_id')
                                    <div class="mt-3 flex items-start gap-3 rounded-xl border border-rose-400/20 bg-rose-500/[0.06] p-3.5"
                                        role="alert">
                                        <span
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-rose-400/20 bg-rose-500/10">
                                            <svg class="h-4 w-4 text-rose-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M12 9v4m0 4h.01M10.3 3.9 2.8 17.5A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.7-2.5L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                                            </svg>
                                        </span>

                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-rose-300">
                                                CV selection required
                                            </p>
                                            <p class="mt-1 break-words text-sm leading-5 text-rose-200/80">
                                                {{ $message }}
                                            </p>
                                        </div>
                                    </div>
                                @enderror

                                <div class="mt-3 flex items-start gap-2 text-xs leading-5 text-slate-500">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="1.6" />
                                        <path stroke-linecap="round" stroke-width="1.6" d="M12 11v5m0-8h.01" />
                                    </svg>
                                    Choose the CV that best matches the position you're applying for.
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-white/[0.08]"></div>
                                </div>

                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-[#080d1d] px-4 text-xs font-medium uppercase tracking-wider text-slate-500">
                                        Or upload a new CV
                                    </span>
                                </div>
                            </div>

                            {{-- Upload New CV --}}
                            <div>
                                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                                    <label for="cv_file" class="text-base font-semibold text-white">
                                        Upload a new resume
                                        <span class="font-normal text-slate-500">(optional)</span>
                                    </label>

                                    <span class="text-xs text-slate-500">
                                        PDF · Max 5 MB
                                    </span>
                                </div>

                                <div class="flex items-stretch gap-2">
                                <label for="cv_file"
                                    class="group flex min-w-0 flex-1 cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed px-5 py-9 text-center transition
                                {{ $hasCvError
                                    ? 'border-rose-400/50 bg-rose-500/[0.035] hover:border-rose-400/70'
                                    : 'border-white/15 bg-[#050816] hover:border-indigo-400/50 hover:bg-indigo-500/[0.03]' }}">

                                    <span
                                        class="flex h-14 w-14 items-center justify-center rounded-2xl border transition group-hover:scale-105
                                    {{ $hasCvError
                                        ? 'border-rose-400/20 bg-rose-500/10 text-rose-300'
                                        : 'border-indigo-400/20 bg-indigo-500/10 text-indigo-300' }}">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                d="M12 16V4m0 0L7 9m5-5 5 5M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3" />
                                        </svg>
                                    </span>

                                    <p class="mt-4 text-sm font-semibold text-slate-200">
                                        Click to browse your files
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Choose your resume from your device
                                    </p>

                                    <span
                                        class="mt-4 inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3 py-1.5 text-xs font-medium text-slate-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                d="M7 3h7l5 5v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h1Zm7 0v5h5M8 14h8m-8 3h8" />
                                        </svg>
                                        PDF document
                                    </span>

                                    <input id="cv_file" name="cv_file" type="file" accept=".pdf,application/pdf"
                                        aria-invalid="{{ $hasCvError ? 'true' : 'false' }}"
                                        aria-describedby="{{ $hasCvError ? 'cv-file-error' : 'cv-file-help' }}"
                                        class="sr-only">
                                </label>

                                <button type="button" id="clear-cv-file" disabled
                                    class="shrink-0 self-center rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-slate-400 transition hover:border-rose-400/30 hover:bg-rose-500/10 hover:text-rose-300 disabled:cursor-not-allowed disabled:opacity-40">
                                    Clear
                                </button>
                                </div>

                                <p id="cv-file-name"
                                    class="mt-3 hidden break-all rounded-xl border border-indigo-400/20 bg-indigo-500/[0.06] px-4 py-3 text-sm text-indigo-200">
                                </p>

                                <p id="cv-file-help" class="mt-3 text-xs leading-5 text-slate-500">
                                    Your resume must be a PDF file no larger than 5 MB.
                                </p>

                                {{-- Professional Validation Error --}}
                                @error('cv_file')
                                    <div id="cv-file-error"
                                        class="mt-4 flex items-start gap-3 rounded-xl border border-rose-400/20 bg-rose-500/[0.07] p-4"
                                        role="alert" aria-live="polite">

                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-rose-400/20 bg-rose-500/10">
                                            <svg class="h-5 w-5 text-rose-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M12 9v4m0 4h.01M10.3 3.9 2.8 17.5A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.7-2.5L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                                            </svg>
                                        </span>

                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-rose-300">
                                                Unable to upload CV
                                            </p>

                                            <p class="mt-1 break-words text-sm leading-6 text-rose-200/80">
                                                {{ $message }}
                                            </p>

                                            <p class="mt-2 text-xs leading-5 text-rose-200/60">
                                                Please check the file requirements and try again.
                                            </p>
                                        </div>
                                    </div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="border-t border-white/[0.08] pt-6">
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-500 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/10 transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60 focus:ring-offset-2 focus:ring-offset-[#080d1d] sm:w-auto">
                                    Apply Now

                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M5 12h14m-7-7 7 7-7 7" />
                                    </svg>
                                </button>

                                <p class="mt-3 text-xs leading-5 text-slate-500">
                                    Please review your selected CV before submitting your application.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Job Summary --}}
                <aside class="h-fit rounded-2xl border border-white/[0.08] bg-[#080d1d] p-5 sm:p-6">

                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/[0.08] bg-white/[0.03] px-3 py-1.5 text-xs font-medium text-slate-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        APPLICATION SUMMARY
                    </span>

                    <h2 class="mt-4 text-sm font-semibold text-slate-300">
                        You're applying for
                    </h2>

                    <div
                        class="mt-5 flex h-12 w-12 items-center justify-center rounded-xl border border-indigo-400/20 bg-indigo-500/10 text-indigo-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="7" width="18" height="13" rx="2" stroke-width="1.7" />
                            <path stroke-linecap="round" stroke-width="1.7" d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                    </div>

                    <h3 class="mt-4 break-words text-lg font-bold leading-7 text-white">
                        {{ $vacancy->title ?? 'Job Position' }}
                    </h3>

                    <p class="mt-1 break-words text-sm text-slate-400">
                        {{ $vacancy->company->name ?? 'Company name' }}
                    </p>

                    <div class="mt-5 space-y-4 border-t border-white/[0.08] pt-5">

                        {{-- Location --}}
                        <div class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                                <circle cx="12" cy="10" r="2.5" stroke-width="1.7" />
                            </svg>

                            <span class="break-words">
                                {{ $vacancy->location ?? 'Location not specified' }}
                            </span>
                        </div>

                        {{-- Job Type --}}
                        <div class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="1.7" />
                                <path stroke-linecap="round" stroke-width="1.7" d="M12 7v5l3 2" />
                            </svg>

                            <span class="break-words">
                                {{ ucfirst(str_replace('_', ' ', $vacancy->type ?? 'Job type')) }}
                            </span>
                        </div>

                        {{-- Salary --}}
                        <div class="flex items-start gap-3 text-sm font-semibold text-emerald-300">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M12 2v20m5-15H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>

                            <span class="break-words">
                                {{ $vacancy->salary ?? 'Negotiable' }}
                            </span>
                        </div>
                    </div>

                    {{-- Helpful Tip --}}
                    <div class="mt-6 rounded-xl border border-indigo-400/15 bg-indigo-500/[0.06] p-4">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-indigo-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M12 18h.01M9.09 9a3 3 0 1 1 5.82 1c-.9.6-1.91 1.2-1.91 2.5M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                            </svg>

                            <p class="text-sm font-semibold text-indigo-300">
                                Before you submit
                            </p>
                        </div>

                        <p class="mt-2 text-xs leading-5 text-slate-400">
                            Make sure your CV is up to date and highlights the experience relevant to this position.
                        </p>
                    </div>

                    <div class="mt-5 flex items-start gap-2 text-xs leading-5 text-slate-500">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M12 11v5m0-8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <p>
                            Your application should include the correct resume for this role.
                        </p>
                    </div>
                </aside>
            </div>

            <footer class="mt-8 border-t border-white/[0.06] pt-5 text-center text-xs text-slate-600">
                © {{ date('Y') }} JobBoard. All rights reserved.
            </footer>
        </div>
    </div>

    <script>
    const cvInput = document.getElementById('cv_file');
    const cvSelect = document.getElementById('cv_id');
    const cvFileName = document.getElementById('cv-file-name');
    const clearCvSelect = document.getElementById('clear-cv-select');
    const clearCvFile = document.getElementById('clear-cv-file');

    function updateClearButtons() {
        clearCvSelect.disabled = !cvSelect.value;
        clearCvFile.disabled = !cvInput.files || cvInput.files.length === 0;
    }

    function clearSelectedFile() {
        cvInput.value = '';
        cvInput.disabled = false;
        cvFileName.textContent = '';
        cvFileName.classList.add('hidden');
        cvSelect.disabled = false;
        updateClearButtons();
    }

    cvInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            cvSelect.value = '';
            cvSelect.disabled = true;
            cvFileName.textContent = 'Selected file: ' + this.files[0].name;
            cvFileName.classList.remove('hidden');
        } else {
            cvSelect.disabled = false;
            cvFileName.textContent = '';
            cvFileName.classList.add('hidden');
        }
        updateClearButtons();
    });

    cvSelect.addEventListener('change', function () {
        if (this.value) {
            cvInput.value = '';
            cvInput.disabled = true;
            cvFileName.textContent = '';
            cvFileName.classList.add('hidden');
        } else {
            cvInput.disabled = false;
        }
        updateClearButtons();
    });

    clearCvSelect.addEventListener('click', function () {
        cvSelect.value = '';
        cvSelect.disabled = false;
        cvInput.disabled = false;
        updateClearButtons();
    });

    clearCvFile.addEventListener('click', clearSelectedFile);

    updateClearButtons();
    </script>
@endsection
