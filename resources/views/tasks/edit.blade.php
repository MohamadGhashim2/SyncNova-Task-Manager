<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تعديل المهمة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">عنوان المهمة:</label>
                        <input type="text" name="title" id="title" value="{{ $task->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">التفاصيل (اختياري):</label>
                        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $task->description }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('tasks.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            إلغاء
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>