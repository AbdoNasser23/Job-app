@extends('layouts.app')

@section('title', 'My Applications - JobBoard')

@section('content')
    <div class="min-h-screen bg-[#050816] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            {{-- Page Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-500/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-indigo-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                        CAREER TRACKER
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">My Applications</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                        Track the jobs you've applied for, review your submitted CV, and check your AI evaluation and feedback.
                    </p>
                </div>
                <a href="{{ url('/dashboard') }}"
                    class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:border-indigo-400/30 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 12H5m7 7-7-7 7-7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Browse jobs
                </a>
            </div>

            {{-- Summary --}}
            <div class="mb-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-5">
                    <p class="text-sm text-slate-400">Total applications</p>
                    <p class="mt-2 text-3xl font-bold text-white">{{ method_exists($applications, 'total') ? $applications->total() : $applications->count() }}</p>
                </div>
                <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-5">
                    <p class="text-sm text-slate-400">Pending applications</p>
                    <p class="mt-2 text-3xl font-bold text-amber-300">
                        {{ $applications->getCollection()->where('status', 'pending')->count() ?? $applications->where('status', 'pending')->count() }}
                    </p>
                </div>
                <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-5">
                    <p class="text-sm text-slate-400">AI evaluations available</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-300">
                        {{ $applications->getCollection()->filter(fn ($application) => $application->ai_generated_score !== null && (float) $application->ai_generated_score > 0)->count() }}
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-400/20 bg-emerald-500/[0.07] px-4 py-3 text-sm text-emerald-300" role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Application Cards --}}
            @forelse ($applications as $application)
                @php
                    $vacancy = $application->jobVacancy ?? $application->vacancy ?? null;
                    $resume = $application->resume ?? null;
                    $score = is_numeric($application->ai_generated_score) ? (float) $application->ai_generated_score : null;
                    $hasScore = $score !== null && $score > 0;
                    $status = strtolower((string) ($application->status ?? 'pending'));
                    $statusClasses = match ($status) {
                        'accepted', 'approved', 'shortlisted' => 'border-emerald-400/20 bg-emerald-500/10 text-emerald-300',
                        'rejected', 'declined' => 'border-rose-400/20 bg-rose-500/10 text-rose-300',
                        'reviewed', 'under_review', 'interview' => 'border-sky-400/20 bg-sky-500/10 text-sky-300',
                        default => 'border-amber-400/20 bg-amber-500/10 text-amber-300',
                    };
                    $feedback = $application->ai_generated_feedback;
                    if (is_string($feedback)) {
                        $decodedFeedback = json_decode($feedback, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedFeedback)) {
                            $feedback = $decodedFeedback['feedback'] ?? $decodedFeedback['explanation'] ?? $decodedFeedback['summary'] ?? $feedback;
                        }
                    }
                @endphp

                <article class="mb-6 overflow-hidden rounded-2xl border border-white/[0.08] bg-[#080d1d] shadow-xl shadow-black/10">
                    {{-- Job header --}}
                    <div class="border-b border-white/[0.08] p-5 sm:p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex min-w-0 gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-indigo-400/20 bg-indigo-500/10 text-indigo-300">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke-width="1.7" />
                                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-width="1.7" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="break-words text-xl font-bold text-white">
                                        {{ $vacancy->title ?? 'Job vacancy no longer available' }}
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-400">
                                        {{ $vacancy?->company?->name ?? 'Company not available' }}
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-xs text-slate-500">
                                        @if ($vacancy?->location)
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" stroke-width="1.6"/><circle cx="12" cy="10" r="2.5" stroke-width="1.6"/></svg>
                                                {{ $vacancy->location }}
                                            </span>
                                        @endif
                                        @if ($vacancy?->type)
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.6"/><path d="M12 7v5l3 2" stroke-width="1.6" stroke-linecap="round"/></svg>
                                                {{ ucfirst(str_replace('_', ' ', $vacancy->type)) }}
                                            </span>
                                        @endif
                                        @if ($vacancy?->salary)
                                            <span class="font-medium text-emerald-300">{{ $vacancy->salary }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="inline-flex w-fit shrink-0 items-center rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </div>

                        <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 border-t border-white/[0.06] pt-4 text-xs text-slate-500">
                            <span>Applied on <strong class="font-medium text-slate-300">{{ $application->created_at?->format('d M Y, h:i A') ?? 'Date unavailable' }}</strong></span>
                            @if ($application->updated_at && $application->updated_at->ne($application->created_at))
                                <span>Last updated <strong class="font-medium text-slate-300">{{ $application->updated_at->format('d M Y') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="grid gap-0 lg:grid-cols-2">
                        {{-- CV card --}}
                        <section class="border-b border-white/[0.08] p-5 sm:p-6 lg:border-b-0 lg:border-r">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M7 3h7l5 5v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h1Zm7 0v5h5M8 14h8m-8 3h8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h3 class="text-sm font-semibold text-white">Submitted CV</h3>
                            </div>

                            @if ($resume && $resume->file_uri)
                                <div class="mt-4 flex items-center justify-between gap-3 rounded-xl border border-white/[0.08] bg-[#050816] p-4">
                                    <div class="min-w-0">
                                        <p class="break-all text-sm font-medium text-slate-200">{{ $resume->file_name ?: 'Resume PDF' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">The CV attached to this application</p>
                                    </div>
                                    <a href="{{ $resume->file_uri }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-indigo-400/20 bg-indigo-500/10 px-3 py-2 text-xs font-semibold text-indigo-200 transition hover:bg-indigo-500/20">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3h7v7m-7-7 7 7M10 14 21 3M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        View CV
                                    </a>
                                </div>
                            @else
                                <p class="mt-4 rounded-xl border border-white/[0.08] bg-[#050816] p-4 text-sm text-slate-500">The CV link is not available for this application.</p>
                            @endif
                        </section>

                        {{-- AI score --}}
                        <section class="p-5 sm:p-6">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 3v3m0 12v3M3 12h3m12 0h3M5.64 5.64l2.12 2.12m8.48 8.48 2.12 2.12m0-12.72-2.12 2.12m-8.48 8.48-2.12 2.12" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="12" r="5" stroke-width="1.6"/>
                                </svg>
                                <h3 class="text-sm font-semibold text-white">AI Resume Evaluation</h3>
                            </div>

                            @if ($hasScore)
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/10">
                                        <span class="text-xl font-bold text-indigo-200">{{ rtrim(rtrim(number_format($score, 1), '0'), '.') }}</span>
                                        <span class="text-[10px] font-medium uppercase tracking-wide text-indigo-300">Score</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="mb-2 flex items-center justify-between gap-2 text-xs text-slate-400">
                                            <span>Resume match score</span>
                                            <span>{{ rtrim(rtrim(number_format($score, 1), '0'), '.') }}%</span>
                                        </div>
                                        <div class="h-2 overflow-hidden rounded-full bg-white/[0.08]">
                                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-violet-400" style="width: {{ max(0, min(100, $score)) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 rounded-xl border border-amber-400/15 bg-amber-500/[0.05] p-4">
                                    <p class="text-sm font-medium text-amber-200">Evaluation pending</p>
                                    <p class="mt-1 text-xs leading-5 text-slate-400">Your AI score will appear here when the resume evaluation has been completed.</p>
                                </div>
                            @endif
                        </section>
                    </div>

                    {{-- Feedback --}}
                    <section class="border-t border-white/[0.08] p-5 sm:p-6">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 11.5a8.5 8.5 0 0 1-12.9 7.3L3 20l1.2-4.2A8.5 8.5 0 1 1 21 11.5Z" stroke-width="1.6" stroke-linejoin="round"/><path d="m8 11 2.5 2.5L16 8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-white">AI Feedback</h3>
                        </div>

                        @if (is_string($feedback) && trim($feedback) !== '')
                            <div class="mt-4 rounded-xl border border-white/[0.08] bg-[#050816] p-4 text-sm leading-7 text-slate-300">
                                {!! nl2br(e($feedback)) !!}
                            </div>
                        @elseif (is_array($feedback) && count($feedback))
                            <div class="mt-4 rounded-xl border border-white/[0.08] bg-[#050816] p-4 text-sm leading-7 text-slate-300">
                                @foreach ($feedback as $key => $value)
                                    <p class="mb-2 last:mb-0">
                                        @if (is_string($key))
                                            <strong class="text-slate-100">{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                        @endif
                                        {{ is_scalar($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                    </p>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-4 rounded-xl border border-white/[0.08] bg-[#050816] p-4 text-sm leading-6 text-slate-500">
                                No AI feedback is available yet for this application.
                            </div>
                        @endif
                    </section>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 bg-[#080d1d] px-6 py-16 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/10 text-indigo-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 7h8M8 11h8m-8 4h5M6 3h9l4 4v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h1Zm8 0v4h5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h2 class="mt-5 text-lg font-bold text-white">No applications yet</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-400">When you apply for a job, it will appear here with its details, submitted CV, status, score, and feedback.</p>
                    <a href="{{ url('/dashboard') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400">
                        Explore available jobs
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            @endforelse

            @if (method_exists($applications, 'links'))
                <div class="mt-6">{{ $applications->links() }}</div>
            @endif

            <footer class="mt-10 border-t border-white/[0.06] pt-5 text-center text-xs text-slate-600">
                © {{ date('Y') }} JobBoard. All rights reserved.
            </footer>
        </div>
    </div>
@endsection
