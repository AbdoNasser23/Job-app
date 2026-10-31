@extends('layouts.app')

@section('title', 'Home - JobBoard')

@section('content')
    @if (session('error'))
        <div id="error-message" class="bg-red-500 text-white p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => document.getElementById('error-message')?.remove(), 2000);
        </script>
    @endif
    <section class="mx-auto flex min-h-[calc(100vh-76px)] max-w-7xl items-center px-6 py-16 sm:px-10 lg:px-12">

        <div class="grid w-full items-center gap-14 lg:grid-cols-2 lg:gap-20">



            {{-- Hero Content --}}
            <div class="text-center lg:text-left">

                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-500/[0.06] px-4 py-2 text-sm text-indigo-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                    A better way to find your future
                </div>

                <h1 class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-[56px]">
                    Build Your Future
                    <span class="block text-indigo-400">
                        With the Right Job.
                    </span>
                </h1>

                <p class="mx-auto mt-6 max-w-lg text-base leading-8 text-gray-400 lg:mx-0">
                    Discover opportunities that match your skills and ambitions.
                    Take the next step in your career with confidence.
                </p>

                <div class="mt-9 flex flex-wrap items-center justify-center gap-4 lg:justify-start">

                    <a href="{{ url('/register') }}"
                        class="inline-flex items-center gap-3 rounded-full bg-indigo-600 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        Get Started

                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ url('/login') }}"
                        class="rounded-full border border-white/10 px-7 py-3.5 text-sm font-medium text-gray-300 transition hover:border-indigo-400/30 hover:text-white">
                        Login
                    </a>

                </div>

            </div>

            {{-- Minimal Illustration --}}
            <div class="relative mx-auto w-full max-w-md">

                <div class="relative overflow-hidden rounded-2xl border border-white/[0.08] bg-dark-900 p-7 sm:p-9">

                    {{-- Subtle decorative background --}}
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-500/[0.07] blur-3xl"></div>

                    <div class="relative">

                        <div class="flex items-center gap-4 border-b border-white/[0.07] pb-6">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.6">
                                    <rect x="3" y="7" width="18" height="14" rx="2" />
                                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    <path d="M3 12h18" />
                                </svg>
                            </div>

                            <div>
                                <h2 class="font-semibold text-white">
                                    Your Next Opportunity
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Start building your career
                                </p>
                            </div>

                        </div>

                        {{-- Simple abstract visual --}}
                        <div class="flex items-center justify-center py-12">

                            <div
                                class="relative flex h-48 w-48 items-center justify-center rounded-full border border-indigo-400/10 bg-indigo-500/[0.025]">

                                <div class="absolute inset-5 rounded-full border border-white/[0.05]"></div>

                                <div
                                    class="flex h-28 w-28 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/[0.08]">
                                    <svg class="h-14 w-14 text-indigo-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.2">
                                        <rect x="3" y="7" width="18" height="14" rx="2" />
                                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <path d="M3 12h18m-11 0v2h4v-2" />
                                    </svg>
                                </div>

                            </div>

                        </div>

                        <div class="border-t border-white/[0.07] pt-5">
                            <p class="text-sm font-medium text-gray-200">
                                Your skills deserve the right opportunity.
                            </p>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Take the first step toward what comes next.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
