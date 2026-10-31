@extends('layouts.app')

@section('title', 'Forgot Password - JobBoard')

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
                        <path d="M12 15v2" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">Forgot your password?</h1>
                <p class="mt-3 text-sm leading-6 text-gray-400">
                    No worries. Enter your email and we'll send you a reset link.
                </p>
            </div>

            <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-6 shadow-xl shadow-black/10 sm:p-8">
                @if (session('status'))
                    <div
                        class="mb-5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-200">
                            Email address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username" placeholder="you@example.com"
                            class="w-full rounded-xl border border-white/10 bg-[#050816] px-4 py-3 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 @error('email') border-red-500/60 @enderror">
                        @error('email')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-400/50">
                        Send reset link
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-gray-400">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-400 transition hover:text-indigo-300">
                        Back to login
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection
