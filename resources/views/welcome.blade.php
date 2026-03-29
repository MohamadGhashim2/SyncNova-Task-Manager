<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SyncNova - {{ __('messages.tasks_management') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300"
    x-data="{ 
        isDark: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        showLang: false 
    }" x-init="if(isDark) document.documentElement.classList.add('dark')">

    <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
        <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight">
            SyncNova<span class="text-yellow-500">.</span>
        </div>

        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="relative" @click.away="showLang = false">
                <button @click="showLang = !showLang"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="text-lg">
                        @if(app()->getLocale() == 'ar') 🇸🇦 @elseif(app()->getLocale() == 'tr') 🇹🇷 @else 🇺🇸 @endif
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="showLang" style="display: none;"
                    class="absolute mt-2 w-32 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 z-50">
                    <a href="{{ route('lang.switch', 'ar') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg">🇸🇦 العربية</a>
                    <a href="{{ route('lang.switch', 'tr') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">🇹🇷 Türkçe</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-lg">🇺🇸 English</a>
                </div>
            </div>

            <button
                @click="isDark = !isDark; localStorage.setItem('theme', isDark ? 'dark' : 'light'); if(isDark) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark')"
                class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-150">
                <span x-show="!isDark">🌙</span>
                <span x-show="isDark" style="display: none;">☀️</span>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/tasks') }}"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-bold transition">
                        {{ __('messages.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-bold transition">
                        {{ __('messages.login') }}
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="container mx-auto px-6 py-20 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
            {{ __('messages.welcome') }}
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
            @if(app()->getLocale() == 'ar')
                {{ __('نظام إدارة مهام احترافي يعتمد على لوحات كانبان (Kanban). نظم عملك، تتبع تقدمك، وحقق أهدافك بسهولة وسرعة فائقة.') }}
            @elseif(app()->getLocale() == 'tr')
                {{ __('Kanban kurallarına dayalı profesyonel görev yönetim sistemi. İşinizi düzenleyin, ilerlemenizi takip edin ve hedeflerinize kolayca ulaşın.') }}
            @else
                {{ __('Professional task management system based on Kanban boards. Organize your work, track progress, and achieve your goals with ease.') }}
            @endif
        </p>

        <div class="flex justify-center gap-4">
            @auth
                <a href="{{ url('/tasks') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-bold shadow-lg transition transform hover:-translate-y-1">
                    {{ __('messages.dashboard') }} 🚀
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-bold shadow-lg transition transform hover:-translate-y-1">
                    {{ __('messages.register') }} 🚀
                </a>
            @endauth
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-blue-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">📋</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">{{ __('messages.pending') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    @if(app()->getLocale() == 'ar') 
                        {{ __('اسحب وأفلت مهامك بين الأعمدة بسلاسة تامة لتنظيم سير العمل.') }} 
                    @else
                        {{ __('Drag and drop tasks smoothly between columns to organize your workflow.') }} 
                    @endif
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-yellow-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">{{ __('messages.fast_smart') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    {{ __('messages.fast_smart_desc') }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-gray-900 dark:border-gray-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">🌙</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">{{ __('messages.dark_mode_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    {{ __('messages.dark_mode_desc') }}
                </p>
            </div>

        </div>
    </main>

    <footer class="border-t border-gray-200 dark:border-gray-800 mt-20 py-8 text-center text-gray-500 dark:text-gray-400 text-sm font-medium">
        {{ __('Developed with love by') }} Mahmoud Ghashim - SyncNova &copy; {{ date('Y') }}
    </footer>

</body>

</html>