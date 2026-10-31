@extends('layouts.app')

@section('title', 'Create Account - JobBoard')

@section('content')
    <section class="flex min-h-[calc(100vh-76px)] items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div
                    class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/10">
                    <svg class="h-7 w-7 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7">
                        <circle cx="9" cy="8" r="4" />
                        <path d="M3 21v-2a6 6 0 0 1 12 0v2M19 8v6M16 11h6" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">Create your account</h1>
                <p class="mt-3 text-sm leading-6 text-gray-400">
                    Join JobBoard and take the next step in your career.
                </p>
            </div>

            <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-6 shadow-xl shadow-black/10 sm:p-8">
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        <p class="mb-1 font-semibold">Please check the following:</p>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-200">
                            Full name
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="Enter your full name"
                            class="w-full rounded-xl border border-white/10 bg-[#050816] px-4 py-3 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 @error('name') border-red-500/60 @enderror">
                        @error('name')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-200">
                            Email address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="you@example.com"
                            class="w-full rounded-xl border border-white/10 bg-[#050816] px-4 py-3 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 @error('email') border-red-500/60 @enderror">
                        @error('email')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-200">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Create a strong password"
                                class="w-full rounded-xl border border-white/10 bg-[#050816] px-4 py-3 pr-12 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 @error('password') border-red-500/60 @enderror">
                            <button type="button" data-password-toggle="password" aria-label="Show password"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 transition hover:text-indigo-400">
                                <svg data-eye class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg data-eye-off class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7">
                                    <path d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                                    <path
                                        d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a16 16 0 0 1-3.1 3.9M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7c1.5 0 2.8-.4 4-1" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-200">
                            Confirm password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Repeat your password"
                                class="w-full rounded-xl border border-white/10 bg-[#050816] px-4 py-3 pr-12 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10">
                            <button type="button" data-password-toggle="password_confirmation" aria-label="Show password"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 transition hover:text-indigo-400">
                                <svg data-eye class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg data-eye-off class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7">
                                    <path d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                                    <path
                                        d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a16 16 0 0 1-3.1 3.9M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7c1.5 0 2.8-.4 4-1" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-400/50">
                        Create account
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-400 transition hover:text-indigo-300">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection
