<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة تحكم SyncNova') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">إجمالي المهام</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $totalTasks }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 text-blue-500 rounded-full">
                            📊
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">المهام المنجزة</p>
                            <h3 class="text-3xl font-bold text-green-600">{{ $completedTasks }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 text-green-500 rounded-full">
                            ✓
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">قيد الانتظار</p>
                            <h3 class="text-3xl font-bold text-yellow-600">{{ $pendingTasks }}</h3>
                        </div>
                        <div class="p-3 bg-yellow-100 text-yellow-500 rounded-full">
                            ⏳
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-6">
                <p class="mb-4 text-gray-600">هل أنت مستعد لإنجاز المزيد اليوم؟</p>
                <a href="{{ route('tasks.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
                    الذهاب إلى إدارة المهام →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>