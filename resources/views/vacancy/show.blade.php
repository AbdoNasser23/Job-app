@extends('layouts.app')

@section('title', $vacancy->title . ' | JobBoard')

@section('content')
<div class="min-h-screen bg-[#050816] px-4 py-10 text-gray-200 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">

        {{-- Back Button --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 transition hover:text-indigo-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Jobs
            </a>
        </div>

        {{-- Main Layout --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Main Content --}}
            <div class="space-y-6 lg:col-span-2">

                {{-- Vacancy Header --}}
                <div class="overflow-hidden rounded-2xl border border-[#182139] bg-[#080d1d]">
                    <div class="border-b border-[#182139] p-6 sm:p-8">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start">

                            {{-- Job Icon --}}
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-indigo-500/20 bg-indigo-500/10">
                                <svg class="h-7 w-7 text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM8 7V5h8v2M2 12h20m-13 0v2h6v-2" />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h1 class="break-words text-2xl font-bold tracking-tight text-white sm:text-3xl">
                                    {{ $vacancy->title }}
                                </h1>

                                <p class="mt-3 text-sm text-gray-400">
                                    {{ $vacancy->company?->name ?? 'Company not available' }}
                                </p>

                                <div class="mt-5 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-2 rounded-lg border border-indigo-500/20 bg-indigo-500/10 px-3 py-1.5 text-xs font-semibold capitalize text-indigo-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                                        {{ str_replace('_', ' ', $vacancy->type ?? 'Not specified') }}
                                    </span>

                                    <span class="inline-flex items-center gap-2 rounded-lg border border-[#26314d] bg-[#10172b] px-3 py-1.5 text-xs font-medium text-gray-300">
                                        <svg class="h-3.5 w-3.5 text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $vacancy->location ?: 'Location not specified' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Created At --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 bg-[#0b1122] px-6 py-4 sm:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-500/10">
                                <svg class="h-5 w-5 text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">Published on</p>
                                <p class="mt-1 text-sm font-semibold text-gray-200">
                                    {{ $vacancy->created_at?->format('M d, Y') ?? 'Date unavailable' }}
                                </p>
                            </div>
                        </div>

                        <span class="text-xs text-gray-500">
                            @if ($vacancy->created_at)
                                {{ $vacancy->created_at->format('h:i A') }}
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Job Description --}}
                <div class="rounded-2xl border border-[#182139] bg-[#080d1d] p-6 sm:p-8">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-indigo-500"></div>
                        <h2 class="text-xl font-bold text-white">Job Description</h2>
                    </div>

                    <div class="whitespace-pre-line break-words text-sm leading-8 text-gray-300 sm:text-base">{{ $vacancy->description ?: 'No description provided for this position.' }}</div>
                </div>

                {{-- Additional Details --}}
                <div class="rounded-2xl border border-[#182139] bg-[#080d1d] p-6 sm:p-8">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-violet-500"></div>
                        <h2 class="text-xl font-bold text-white">Job Details</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- Job Type --}}
                        <div class="rounded-xl border border-[#182139] bg-[#050816]/70 p-4">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-indigo-500/10 p-2.5">
                                    <svg class="h-5 w-5 text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.8"
                                            d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Employment Type</p>
                                    <p class="mt-1 text-sm font-semibold capitalize text-gray-200">
                                        {{ str_replace('_', ' ', $vacancy->type ?? 'Not specified') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="rounded-xl border border-[#182139] bg-[#050816]/70 p-4">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-blue-500/10 p-2.5">
                                    <svg class="h-5 w-5 text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.8"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.8"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Location</p>
                                    <p class="mt-1 break-words text-sm font-semibold text-gray-200">
                                        {{ $vacancy->location ?: 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="rounded-xl border border-[#182139] bg-[#050816]/70 p-4">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-violet-500/10 p-2.5">
                                    <svg class="h-5 w-5 text-violet-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 7h.01M7 3h5l9 9-9 9-9-9V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Category</p>
                                    <p class="mt-1 break-words text-sm font-semibold text-gray-200">
                                        {{ $vacancy->jobCategory?->name ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Salary --}}
                        <div class="rounded-xl border border-[#182139] bg-[#050816]/70 p-4">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-emerald-500/10 p-2.5">
                                    <svg class="h-5 w-5 text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 2v8m0 0v2m8-6a8 8 0 11-16 0 8 8 0 0116 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Salary</p>
                                    <p class="mt-1 text-sm font-semibold text-emerald-400">
                                        {{ $vacancy->salary !== null && $vacancy->salary !== '' ? $vacancy->salary : 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">

                {{-- Apply Card --}}
                <div class="rounded-2xl border border-[#182139] bg-[#080d1d] p-6">
                    <h2 class="text-lg font-bold text-white">Interested in this job?</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Take the next step in your career and apply for this position.
                    </p>

                    <a href="{{route('vacancy.apply',$vacancy->id)}}"
                        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/10 transition hover:bg-indigo-400">
                        Apply Now
                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M7 17L17 7M7 7h10v10" />
                        </svg>
                    </a>

                    <p class="mt-3 text-center text-xs text-gray-500">
                        Review the job details before applying.
                    </p>
                </div>

                {{-- Company Card --}}
                <div class="rounded-2xl border border-[#182139] bg-[#080d1d] p-6">
                    <h2 class="text-lg font-bold text-white">About the Company</h2>

                    <div class="mt-5 flex items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-indigo-500/20 bg-indigo-500/10">
                            <svg class="h-6 w-6 text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01M15 14v.01M15 17v.01" />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="break-words font-semibold text-white">
                                {{ $vacancy->company?->name ?? 'Company not available' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">Hiring Company</p>
                        </div>
                    </div>

                    @if ($vacancy->company?->address)
                        <div class="mt-5 border-t border-[#182139] pt-4">
                            <p class="text-xs text-gray-500">Company Address</p>
                            <p class="mt-2 break-words text-sm leading-6 text-gray-300">
                                {{ $vacancy->company->address }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Vacancy Stats --}}
                <div class="rounded-2xl border border-[#182139] bg-[#080d1d] p-6">
                    <h2 class="text-lg font-bold text-white">Job Statistics</h2>

                    <div class="mt-5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-blue-500/10 p-2">
                                <svg class="h-5 w-5 text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.8"
                                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-400">Views</span>
                        </div>

                        <span class="text-lg font-bold text-white">
                            {{ number_format($vacancy->view_count ?? 0) }}
                        </span>
                    </div>

                    <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#182139] pt-4">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-violet-500/10 p-2">
                                <svg class="h-5 w-5 text-violet-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-400">Date Posted</span>
                        </div>

                        <span class="text-sm font-semibold text-gray-200">
                            {{ $vacancy->created_at?->format('M d, Y') ?? 'N/A' }}
                        </span>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</div>
@endsection

