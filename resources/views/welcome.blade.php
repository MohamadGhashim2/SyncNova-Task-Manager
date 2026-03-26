<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SyncNova - إدارة المهام بذكاء</title>

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
    x-data="{ isDark: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
    x-init="if(isDark) document.documentElement.classList.add('dark')">

    <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
        <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight">
            SyncNova<span class="text-yellow-500">.</span>
        </div>

        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <button
                @click="isDark = !isDark; localStorage.setItem('theme', isDark ? 'dark' : 'light'); if(isDark) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark')"
                class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-150">
                <span x-show="!isDark" title="تفعيل الوضع الليلي">🌙</span>
                <span x-show="isDark" style="display: none;" title="تفعيل الوضع النهاري">☀️</span>
            </button>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/tasks') }}"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-bold transition">الذهاب
                        لمهامي</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-bold transition">تسجيل
                        الدخول</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold transition shadow-md">إنشاء
                            حساب</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="container mx-auto px-6 py-20 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
            أنجز مهامك بكفاءة مع <span class="text-blue-600 dark:text-blue-400">SyncNova</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
            نظام إدارة مهام احترافي يعتمد على لوحات كانبان (Kanban). نظم عملك، تتبع تقدمك، وحقق أهدافك بسهولة وسرعة
            فائقة في مكان واحد.
        </p>

        <div class="flex justify-center gap-4">
            @auth
                <a href="{{ url('/tasks') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-bold shadow-lg transition transform hover:-translate-y-1">
                    الذهاب للوحة المهام 🚀
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-bold shadow-lg transition transform hover:-translate-y-1">
                    ابدأ الآن مجاناً 🚀
                </a>
            @endauth
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 text-right">

            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-blue-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">📋</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">لوحات كانبان تفاعلية</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    اسحب وأفلت مهامك بين الأعمدة بسلاسة تامة لتنظيم سير العمل ورؤية الصورة الكاملة لمشروعك.
                </p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-yellow-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">سرعة فائقة</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    واجهات تفاعلية ذكية بدون الحاجة لإعادة تحميل الصفحة، لتجربة مستخدم سلسة ولا مثيل لها.
                </p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border-t-4 border-gray-900 dark:border-gray-500 hover:shadow-xl transition duration-300">
                <div class="text-4xl mb-4">🌙</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">وضع ليلي مريح</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    اعمل في أي وقت من اليوم بأريحية تامة مع واجهة تدعم الوضع الليلي بشكل كامل لحماية عينيك.
                </p>
            </div>

        </div>
    </main>

    <footer
        class="border-t border-gray-200 dark:border-gray-800 mt-20 py-8 text-center text-gray-500 dark:text-gray-400 text-sm font-medium">
        تم التطوير بحب بواسطة محمد غشيم - SyncNova &copy; {{ date('Y') }}
    </footer>

</body>

</html>