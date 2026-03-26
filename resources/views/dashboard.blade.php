<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors duration-300">
            {{ __('لوحة تحكم SyncNova') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 transition-colors duration-300">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1">إجمالي المهام</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalTasks }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 rounded-full transition-colors duration-300">
                            📊
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 transition-colors duration-300">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1">المهام المنجزة</p>
                            <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $completedTasks }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/50 text-green-500 dark:text-green-400 rounded-full transition-colors duration-300">
                            ✓
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500 transition-colors duration-300">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1">قيد الانتظار</p>
                            <h3 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $pendingTasks }}</h3>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-500 dark:text-yellow-400 rounded-full transition-colors duration-300">
                            ⏳
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-center p-6 transition-colors duration-300">
                <p class="mb-4 text-gray-600 dark:text-gray-300">هل أنت مستعد لإنجاز المزيد اليوم؟</p>
                <a href="{{ route('tasks.index') }}" class="inline-block bg-gray-800 dark:bg-blue-600 hover:bg-gray-700 dark:hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
                    الذهاب إلى إدارة المهام →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>