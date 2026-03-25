<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة مهام SyncNova') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4 flex justify-end">
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow inline-block text-center">
    + إضافة مهمة جديدة
</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        
                        @if($tasks->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                لا يوجد لديك أي مهام حالياً. ابدأ بإضافة مهمتك الأولى!
                            </div>
                        @else
                                     @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm" role="alert">
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif
                        @endif
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="py-3 px-4 border-b">عنوان المهمة</th>
                                    <th class="py-3 px-4 border-b">الحالة</th>
                                    <th class="py-3 px-4 border-b">تاريخ الإنشاء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">{{ $task->title }}</td>
                                        <td class="py-3 px-4 border-b">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                                {{ $task->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border-b text-sm text-gray-500">
                                            {{ $task->created_at->diffForHumans() }}
                                        </td>
                                        <td class="py-3 px-4 border-b space-x-2 rtl:space-x-reverse text-sm text-gray-500">
                                            @if($task->status !== 'completed')
                                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
                                                    إنجاز ✓
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('هل أنت متأكد من حذف هذه المهمة؟')">
                                                    حذف ✕
                                                </button>
                                            </form>

                                            <a href="{{ route('tasks.edit', $task) }}" class="inline-block text-xs bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                                    تعديل ✎
                                            </a>
                                                
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>