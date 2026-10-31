@extends('layouts.app')

@section('title', 'Verify Email - JobBoard')

@section('content')
    <section class="flex min-h-[calc(100vh-76px)] items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <div
                    class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-500/10">
                    <svg class="h-7 w-7 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <path d="m3 7 9 6 9-6" />
                        <path d="m9 15 2 2 4-4" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Verify your email
                </h1>

                <p class="mt-3 text-sm leading-6 text-gray-400">
                    You're almost there! Please verify your email address to activate your account and access JobBoard.
                </p>
            </div>

            <div class="rounded-2xl border border-white/[0.08] bg-[#080d1d] p-6 shadow-xl shadow-black/10 sm:p-8">

                @if (session('status') === 'verification-link-sent')
                    <div
                        class="mb-5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm leading-6 text-emerald-300">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                @if (session('status') && session('status') !== 'verification-link-sent')
                    <div
                        class="mb-5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm leading-6 text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-6 rounded-xl border border-white/[0.06] bg-[#050816] p-4">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 11v5M12 8h.01" />
                        </svg>

                        <p class="text-sm leading-6 text-gray-400">
                            Check your inbox and spam folder. If you haven't received the email, you can request another
                            verification link below.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                    @csrf

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-400/50">
                        Resend verification email
                    </button>
                </form>

                <div class="my-6 border-t border-white/[0.08]"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-medium text-gray-300 transition hover:border-red-400/30 hover:bg-red-500/5 hover:text-red-300">
                        Log out
                    </button>
                </form>

            </div>

            <p class="mt-6 text-center text-xs leading-5 text-gray-500">
                Didn't receive the email? Make sure the email address you registered with is correct.
            </p>

        </div>
    </section>
@endsection
