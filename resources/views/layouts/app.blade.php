<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'JobBoard')</title>

    <meta name="description" content="JobBoard helps you take the next step in your career.">

    <meta name="theme-color" content="#050816">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            950: '#050816',
                            900: '#080d1d',
                            800: '#10172b',
                            700: '#182139',
                        },
                    },
                },
            },
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #050816;
            color: #f9fafb;
        }

        ::selection {
            background-color: rgba(99, 102, 241, 0.4);
            color: white;
        }

        a,
        button {
            -webkit-tap-highlight-color: transparent;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen antialiased">

    {{-- Main Navbar --}}
    <header class="sticky top-0 z-50 border-b border-white/[0.06]
                   bg-[#050816]/85 backdrop-blur-xl">

        <nav
            class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10
                    h-[76px] flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group" aria-label="JobBoard home">

                <span
                    class="flex h-10 w-10 items-center justify-center
                             rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600
                             shadow-lg shadow-indigo-600/20
                             transition duration-300 group-hover:scale-105">

                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                        <rect x="3" y="7" width="18" height="14" rx="2" />
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <path d="M3 12h18M10 12v2h4v-2" />
                    </svg>

                </span>

                <span class="text-xl font-bold tracking-tight text-white">
                    Job<span class="text-indigo-400">Board</span>
                </span>

            </a>

            {{-- Authentication Actions --}}
            <div class="flex items-center gap-3 sm:gap-4">

                @guest

                    <a href="{{ url('/login') }}"
                        class="rounded-full px-4 sm:px-6 py-2.5
                              text-sm font-medium text-gray-300
                              transition duration-300
                              hover:bg-white/[0.06] hover:text-white">

                        Login
                    </a>

                    <a href="{{ url('/register') }}"
                        class="rounded-full bg-gradient-to-r
                              from-indigo-600 to-violet-600
                              px-4 sm:px-6 py-2.5
                              text-sm font-semibold text-white
                              shadow-lg shadow-indigo-600/20
                              transition duration-300
                              hover:-translate-y-0.5
                              hover:shadow-indigo-500/30">

                        Sign Up
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="rounded-full border border-white/10
                              px-4 sm:px-6 py-2.5
                              text-sm font-medium text-gray-200
                              transition duration-300
                              hover:border-indigo-400/40
                              hover:bg-white/[0.05]">

                        Dashboard
                    </a>

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="rounded-full px-3 sm:px-5 py-2.5
                                       text-sm font-medium text-gray-400
                                       transition duration-300
                                       hover:bg-red-500/10 hover:text-red-400">

                            Logout
                        </button>
                    </form>

                @endguest

            </div>

        </nav>

    </header>


    {{-- Page Content --}}
    <main class="relative min-h-[calc(100vh-76px)]">

        @yield('content')

    </main>

    {{-- Password Toggle Script --}}
    <script>
    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-password-toggle]');

        if (!button) return;

        const input = document.getElementById(button.dataset.passwordToggle);

        if (!input) return;

        const showPassword = input.type === 'password';

        input.type = showPassword ? 'text' : 'password';

        button.querySelector('[data-eye]').classList.toggle('hidden', !showPassword);
        button.querySelector('[data-eye-off]').classList.toggle('hidden', showPassword);

        button.setAttribute(
            'aria-label',
            showPassword ? 'Hide password' : 'Show password'
        );
    });
</script>

    {{-- Page Scripts --}}
    @stack('scripts')

</body>

</html>
