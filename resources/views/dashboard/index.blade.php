@extends('layouts.app')

@section('title', 'Dashboard - Job Board')

@section('content')
    <div class="min-h-screen bg-[#050816] px-4 py-8 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-7xl">

            {{-- Navigation --}}
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">
                        Job<span class="text-indigo-400">Board</span>
                    </h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Find your next opportunity.
                    </p>
                </div>

                <nav class="flex items-center gap-2 rounded-xl border border-white/10 bg-[#080d1d] p-1.5">
                    <a href="{{ url('/dashboard') }}"
                        class="rounded-lg bg-indigo-500/15 px-4 py-2.5 text-sm font-semibold text-indigo-300">
                        Dashboard
                    </a>

                    <a href="{{ route('application.index') }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                        My Applications
                    </a>
                </nav>
            </div>

            {{-- Welcome Section --}}
            <section
                class="relative mb-8 overflow-hidden rounded-2xl border border-indigo-400/20 bg-gradient-to-br from-[#111a35] via-[#0b1025] to-[#080d1d] p-6 sm:p-9">

                <div
                    class="pointer-events-none absolute -right-16 -top-24 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl">
                </div>
                <div
                    class="pointer-events-none absolute -bottom-24 right-1/3 h-48 w-48 rounded-full bg-violet-500/10 blur-3xl">
                </div>

                <div class="relative z-10 max-w-2xl">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-400/10 px-3 py-1.5 text-xs font-semibold text-indigo-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                        YOUR CAREER STARTS HERE
                    </span>

                    <h2 class="mt-5 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl">
                        Welcome back,
                        <span class="text-indigo-400">{{ auth()->user()->name }}</span>!
                    </h2>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                        Ready for your next career move? Explore opportunities,
                        discover companies, and find a job that matches your ambitions.
                    </p>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a href="#available-jobs"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-400">
                            Explore Jobs
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14m-7-7 7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('application.index') }}"
                            class="rounded-xl border border-white/10 bg-white/[0.03] px-5 py-3 text-sm font-semibold text-slate-300 transition hover:border-white/20 hover:bg-white/[0.06] hover:text-white">
                            View My Applications
                        </a>
                    </div>
                </div>
            </section>

            {{-- Search and Filters --}}
            <section class="mb-6 rounded-2xl border border-white/[0.08] bg-[#080d1d] p-4 sm:p-5">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                    {{-- Search Form: Design Only --}}
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="w-full xl:max-w-md">
                            <label for="job-search" class="mb-2 block text-sm font-medium text-slate-300">
                                Search opportunities
                            </label>

                            <div
                                class="flex items-center gap-2 rounded-xl border border-white/10 bg-[#050816] px-3 py-1.5 transition focus-within:border-indigo-400/50">

                                <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="7" stroke-width="1.8" />
                                    <path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4" />
                                </svg>

                                @csrf
                                <input id="job-search" type="text" placeholder="Job title, company, or location..."
                                    name="search" value="{{ request('search') }}"
                                    class="w-full border-0 bg-transparent py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:ring-0">

                                <button type="submit"
                                    class="shrink-0 rounded-lg bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-400">
                                    Search
                                </button>
                                <a href="{{ route('dashboard', ['type' => request('type')]) }}"
                                    class="shrink-0 inline-flex items-center gap-2 rounded-lg border border-gray-700
                                            bg-[#10172b] px-4 py-2.5 text-sm font-semibold text-gray-300
                                            transition-all duration-200
                                            hover:border-indigo-500/50 hover:bg-indigo-500/10 hover:text-indigo-400
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500/30">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>

                                    Clear
                                </a>

                                @if (request('type'))
                                    <input type="hidden" name="type" value="{{ request('type') }}">
                                @endif

                            </div>

                        </div>
                    </form>

                    {{-- Job Type Filters: Design Only --}}
                    <div class="w-full xl:w-auto">
                        <p class="mb-2 text-sm font-medium text-slate-300">
                            Job type
                        </p>
                        @php
                            $currentClick =
                                'border-indigo-400/30 bg-indigo-500/15 font-semibold text-indigo-300  transition hover:border-indigo-400/50';
                            $otherClick =
                                ' border-white/10 bg-white/[0.02] font-medium text-slate-400 transition hover:border-indigo-400/30 hover:bg-indigo-500/10 hover:text-indigo-300';
                        @endphp

                        <div class="flex flex-wrap gap-2">
                            <form action="{{ route('dashboard') }}" method="GET">

                                @csrf
                                <button type="submit" value ="all_jobs" name="type"
                                    class="rounded-xl border {{ request('type', 'all_jobs') == 'all_jobs' ? $currentClick : $otherClick }}  px-4 py-2.5 text-sm  ">
                                    All Jobs
                                </button>

                                <button type="submit" value ="full_time" name="type"
                                    class="rounded-xl border {{ request('type') == 'full_time' ? $currentClick : $otherClick }}   px-4 py-2.5 text-sm">
                                    Full-time
                                </button>

                                <button type="submit" value ="contract" name="type"
                                    class="rounded-xl border {{ request('type') == 'contract' ? $currentClick : $otherClick }}   px-4 py-2.5 text-sm">
                                    Contract
                                </button>

                                <button type="submit" value ="remote" name="type"
                                    class="rounded-xl border {{ request('type') == 'remote' ? $currentClick : $otherClick }}   px-4 py-2.5 text-sm">
                                    Remote
                                </button>

                                <button type="submit" value ="hybrid" name="type"
                                    class="rounded-xl border {{ request('type') == 'hybrid' ? $currentClick : $otherClick }}   px-4 py-2.5 text-sm">
                                    Hybrid
                                </button>
                                @if (request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                            </form>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Available Jobs --}}
            <section id="available-jobs" class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#080d1d]">

                {{-- Section Header --}}
                <div
                    class="flex flex-col gap-3 border-b border-white/[0.08] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold text-white">
                            Available Opportunities
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Explore jobs and take the next step in your career.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-lg border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs font-medium text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 6h16M7 12h10m-7 6h4" />
                        </svg>
                        Latest opportunities
                    </span>
                </div>

                {{-- Jobs Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left">
                        <thead class="border-b border-white/[0.08] bg-white/[0.02]">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Position
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Company
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Location
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Job Type
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Salary
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Category
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/[0.06]">

                            @forelse (($jobs ?? collect()) as $job)
                                <tr class="transition hover:bg-white/[0.025]">

                                    {{-- Position --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-indigo-400/15 bg-indigo-500/10 text-indigo-300">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <rect x="3" y="7" width="18" height="13" rx="2"
                                                        stroke-width="1.7" />
                                                    <path stroke-linecap="round" stroke-width="1.7"
                                                        d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18m-11 0v2h4v-2" />
                                                </svg>
                                            </div>

                                            <div class="max-w-[230px]">
                                                <p class="font-semibold text-white">
                                                    {{ $job->title }}
                                                </p>

                                                <p class="mt-1 truncate text-xs text-slate-500">
                                                    {{ \Illuminate\Support\Str::limit($job->description, 55) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Company --}}
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-medium text-slate-300">
                                            {{ optional($job->company)->name ?? 'Not specified' }}
                                        </span>
                                    </td>

                                    {{-- Location --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2 text-sm text-slate-400">
                                            <svg class="h-4 w-4 shrink-0 text-slate-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                    d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                                                <circle cx="12" cy="10" r="2.5" stroke-width="1.7" />
                                            </svg>

                                            {{ $job->location ?: 'Not specified' }}
                                        </div>
                                    </td>

                                    {{-- Job Type --}}
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex rounded-lg border border-violet-400/15 bg-violet-500/10 px-2.5 py-1.5 text-xs font-medium text-violet-300">
                                            {{ ucfirst(str_replace('-', ' ', $job->type ?? 'Not specified')) }}
                                        </span>
                                    </td>

                                    {{-- Salary --}}
                                    <td class="px-6 py-5">
                                        <span class="whitespace-nowrap text-sm font-semibold text-emerald-300">
                                            {{ $job->salary ?: 'Negotiable' }}
                                        </span>
                                    </td>

                                    {{-- Category --}}
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-slate-400">
                                            {{ $job->jobCategory->name ?? 'General' }}
                                        </span>
                                    </td>

                                    {{-- Apply --}}
                                    <td class="px-6 py-5 text-right">
                                        <a href="{{route('vacancy.show',$job->id)}}"
                                            class="inline-flex items-center gap-2 rounded-lg border border-indigo-500/30
                                                    bg-indigo-500/10 px-4 py-2.5 text-sm font-semibold text-indigo-400
                                                    transition-all duration-200 hover:border-indigo-400
                                                    hover:bg-indigo-500 hover:text-white">

                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                                <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                                            </svg>

                                            Show
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.03] text-slate-500">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <rect x="3" y="7" width="18" height="13" rx="2"
                                                    stroke-width="1.5" />
                                                <path stroke-linecap="round" stroke-width="1.5"
                                                    d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-white">
                                            No jobs available yet
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            New opportunities will appear here when they become available.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if (isset($jobs) && method_exists($jobs, 'links') && $jobs->hasPages())
                    <div class="border-t border-white/[0.08] px-5 py-4 sm:px-6">
                        {{ $jobs->links() }}
                    </div>
                @endif

            </section>

            {{-- Footer --}}
            <footer
                class="mt-8 flex flex-col items-center justify-between gap-2 border-t border-white/[0.06] pt-5 text-xs text-slate-600 sm:flex-row">
                <p>© {{ date('Y') }} JobBoard. All rights reserved.</p>
                <p>Build your future, one opportunity at a time.</p>
            </footer>

        </div>
    </div>
@endsection
