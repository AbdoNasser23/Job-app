@extends('layouts.app')

@section('title', 'Confirm Password - JobBoard')

@section('content')
    <section class="flex min-h-[calc(100vh-76px)] items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div
                    class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/10">
                    <svg class="h-7 w-7 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7">
                        <rect x="4" y="11" width="16" height="10" rx="2" />
                        <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        <circle cx="12" cy="16" r="1" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">Confirm your password</h1>
                <p class="mt-3 text-sm leading-6 text-gray-400">
                    For your security, please confirm your password before continuing.
                </p>
            </div>

            <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-6 shadow-xl shadow-black/10 sm:p-8">
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-200">
                            Password
                        </label>

                        <div class="relative">
                            <input id="password" type="password" name="password" required autofocus
                                autocomplete="current-password" placeholder="Enter your password"
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

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-400/50">
                        Confirm password
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
