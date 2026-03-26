<style>
    .dragging-item-clone {
        display: block !important; /* حل مشكلة اختفاء الكرت أثناء السحب */
        opacity: 1 !important;
        background-color: white !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        cursor: grabbing !important;
        border: 2px solid #60a5fa !important;
        z-index: 99999 !important;
        transition: none !important;
    }

    :is(.dark .dragging-item-clone) {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
        border-color: #3b82f6 !important;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('إدارة المهام SyncNova') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
            showAddModal: false, 
            showEditModal: false, 
            editFormAction: '', 
            editTitle: '', 
            editDescription: '',
            editPriority: 'low',
            editDueDate: '',
            isSubmitting: false,
            searchQuery: '', 
            
            openEdit(id, title, desc, priority, dueDate) {
                this.editFormAction = '/tasks/' + id;
                this.editTitle = title;
                this.editDescription = desc;
                this.editPriority = priority;
                this.editDueDate = dueDate || '';
                this.showEditModal = true;
                this.isSubmitting = false; 
            }
        }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="mb-6 flex flex-col md:flex-row justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm transition-colors duration-300 gap-4">
                
                <div class="w-full md:w-1/2 relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors" placeholder="ابحث في المهام...">
                </div>

                <button @click="showAddModal = true; isSubmitting = false;"
                    class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
                    + إضافة مهمة جديدة
                </button>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    x-transition:enter="transform ease-out duration-300 transition"
                    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed bottom-5 right-5 rtl:left-5 rtl:right-auto z-[999999] flex items-center p-4 mb-4 bg-white rounded-lg shadow-2xl dark:bg-gray-800 border-r-4 border-green-500"
                    role="alert">

                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-400">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                    </div>
                    <div class="ms-3 rtl:mr-3 rtl:ml-0 text-sm font-bold text-gray-800 dark:text-gray-200">
                        {{ session('success') }}
                    </div>
                    <button type="button" @click="show = false"
                        class="ms-auto rtl:mr-auto rtl:ml-0 -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-yellow-400 dark:border-yellow-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>⏳ قيد الانتظار</span>
                        <span id="count-pending" class="bg-yellow-200 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'pending')->count() }}</span>
                    </h3>

                    <div id="pending" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'pending') as $task)
                            <div data-id="{{ $task->id }}"
                                 data-search="{{ htmlspecialchars($task->title . ' ' . ($task->description ?? ''), ENT_QUOTES) }}"
                                 x-show="searchQuery === '' || $el.dataset.search.toLowerCase().includes(searchQuery.toLowerCase())"
                                 x-transition.opacity.duration.300ms
                                class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm cursor-grab active:cursor-grabbing hover:shadow-lg hover:border-2 hover:border-yellow-400 dark:hover:border-yellow-500 transition-shadow duration-150 ease-in-out relative">

                                <div class="absolute top-3 left-3 rtl:right-3 rtl:left-auto">
                                    <span class="text-[11px] px-2 py-1 rounded-md font-bold shadow-sm border
                                        {{ $task->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400 dark:border-red-800' : '' }}
                                        {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-400 dark:border-yellow-800' : '' }}
                                        {{ $task->priority == 'low' ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-400 dark:border-blue-800' : '' }}
                                    ">
                                        {{ $task->priority == 'high' ? '🔴 عاجل' : ($task->priority == 'medium' ? '🟡 متوسط' : '🔵 عادي') }}
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-800 dark:text-white text-lg mt-4">{{ $task->title }}</h4>
                                <p class="text-xs text-gray-400 dark:text-gray-400 mt-1 mb-2">
                                    {{ $task->created_at->diffForHumans() }}
                                </p>

                                @if($task->due_date)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($task->due_date)->endOfDay();
                                        $now = \Carbon\Carbon::now();
                                        $isOverdue = $dueDate->isPast();
                                        $daysLeft = $now->diffInDays($dueDate, false);
                                        
                                        if($isOverdue){
                                            $timeText = 'متأخرة';
                                            $colorClass = 'text-red-500 dark:text-red-400';
                                        } elseif ($daysLeft == 0) {
                                             $timeText = 'اليوم';
                                             $colorClass = 'text-yellow-600 dark:text-yellow-500';
                                        } elseif ($daysLeft == 1) {
                                            $timeText = 'غداً';
                                            $colorClass = 'text-gray-500 dark:text-gray-400';
                                        } else {
                                            $timeText = 'متبقي ' . intval($daysLeft) . ' أيام';
                                            $colorClass = 'text-gray-500 dark:text-gray-400';
                                        }
                                    @endphp
                                    <div class="due-date-display mt-1 flex items-center text-xs font-semibold {{ $colorClass }}">
                                        <svg class="w-4 h-4 rtl:ml-1 ltr:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $task->due_date->format('Y-m-d') }} <span class="mx-1">({{ $timeText }})</span>
                                    </div>
                                @endif

                                <div class="flex justify-end items-center border-t dark:border-gray-700 pt-3 mt-2">
                                    <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                        <button type="button"
                                            @click="openEdit({{ $task->id }}, $el.dataset.title, $el.dataset.desc, $el.dataset.priority, $el.dataset.duedate)"
                                            data-title="{{ $task->title }}" data-desc="{{ $task->description ?? '' }}"
                                            data-priority="{{ $task->priority }}" data-duedate="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                                            class="edit-btn text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 text-lg flex items-center justify-center pt-1 transition-colors">✎</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="m-0 p-0 flex items-center justify-center">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="delete-btn text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-lg flex items-center justify-center transition-colors"
                                                onclick="return confirm('حذف المهمة؟')">✕</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-blue-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>🚀 قيد التنفيذ</span>
                        <span id="count-in_progress" class="bg-blue-200 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                    </h3>

                    <div id="in_progress" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'in_progress') as $task)
                            <div data-id="{{ $task->id }}"
                                 data-search="{{ htmlspecialchars($task->title . ' ' . ($task->description ?? ''), ENT_QUOTES) }}"
                                 x-show="searchQuery === '' || $el.dataset.search.toLowerCase().includes(searchQuery.toLowerCase())"
                                 x-transition.opacity.duration.300ms
                                class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm cursor-grab active:cursor-grabbing hover:shadow-lg hover:border-2 hover:border-blue-400 dark:hover:border-blue-500 transition-shadow duration-150 ease-in-out relative">

                                <div class="absolute top-3 left-3 rtl:right-3 rtl:left-auto">
                                    <span class="text-[11px] px-2 py-1 rounded-md font-bold shadow-sm border
                                        {{ $task->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400 dark:border-red-800' : '' }}
                                        {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-400 dark:border-yellow-800' : '' }}
                                        {{ $task->priority == 'low' ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-400 dark:border-blue-800' : '' }}
                                    ">
                                        {{ $task->priority == 'high' ? '🔴 عاجل' : ($task->priority == 'medium' ? '🟡 متوسط' : '🔵 عادي') }}
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-800 dark:text-white text-lg mt-4">{{ $task->title }}</h4>
                                <p class="text-xs text-gray-400 dark:text-gray-400 mt-1 mb-2">
                                    {{ $task->created_at->diffForHumans() }}
                                </p>

                                @if($task->due_date)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($task->due_date)->endOfDay();
                                        $now = \Carbon\Carbon::now();
                                        $isOverdue = $dueDate->isPast();
                                        $daysLeft = $now->diffInDays($dueDate, false);
                                        
                                        if($isOverdue){
                                            $timeText = 'متأخرة';
                                            $colorClass = 'text-red-500 dark:text-red-400';
                                        } elseif ($daysLeft == 0) {
                                             $timeText = 'اليوم';
                                             $colorClass = 'text-yellow-600 dark:text-yellow-500';
                                        } elseif ($daysLeft == 1) {
                                            $timeText = 'غداً';
                                            $colorClass = 'text-gray-500 dark:text-gray-400';
                                        } else {
                                            $timeText = 'متبقي ' . intval($daysLeft) . ' أيام';
                                            $colorClass = 'text-gray-500 dark:text-gray-400';
                                        }
                                    @endphp
                                    <div class="due-date-display mt-1 flex items-center text-xs font-semibold {{ $colorClass }}">
                                        <svg class="w-4 h-4 rtl:ml-1 ltr:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $task->due_date->format('Y-m-d') }} <span class="mx-1">({{ $timeText }})</span>
                                    </div>
                                @endif

                                <div class="flex justify-end items-center border-t dark:border-gray-700 pt-3 mt-2">
                                    <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                        <button type="button"
                                            @click="openEdit({{ $task->id }}, $el.dataset.title, $el.dataset.desc, $el.dataset.priority, $el.dataset.duedate)"
                                            data-title="{{ $task->title }}" data-desc="{{ $task->description ?? '' }}"
                                            data-priority="{{ $task->priority }}" data-duedate="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                                            class="edit-btn text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 text-lg flex items-center justify-center pt-1 transition-colors">✎</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="m-0 p-0 flex items-center justify-center">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="delete-btn text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-lg flex items-center justify-center transition-colors"
                                                onclick="return confirm('حذف المهمة؟')">✕</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-green-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>✅ مكتملة</span>
                        <span id="count-completed" class="bg-green-200 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </h3>

                    <div id="completed" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'completed') as $task)
                            <div data-id="{{ $task->id }}"
                                 data-search="{{ htmlspecialchars($task->title . ' ' . ($task->description ?? ''), ENT_QUOTES) }}"
                                 x-show="searchQuery === '' || $el.dataset.search.toLowerCase().includes(searchQuery.toLowerCase())"
                                 x-transition.opacity.duration.300ms
                                class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm cursor-grab active:cursor-grabbing opacity-75 hover:opacity-100 transition duration-150 ease-in-out border-r-4 border-transparent hover:border-green-400 dark:hover:border-green-500 relative">

                                <div class="absolute top-3 left-3 rtl:right-3 rtl:left-auto">
                                    <span class="text-[11px] px-2 py-1 rounded-md font-bold shadow-sm border opacity-50
                                        {{ $task->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400 dark:border-red-800' : '' }}
                                        {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-400 dark:border-yellow-800' : '' }}
                                        {{ $task->priority == 'low' ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-400 dark:border-blue-800' : '' }}
                                    ">
                                        {{ $task->priority == 'high' ? '🔴 عاجل' : ($task->priority == 'medium' ? '🟡 متوسط' : '🔵 عادي') }}
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-500 dark:text-gray-400 text-lg line-through mt-4">
                                    {{ $task->title }}
                                </h4>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 mb-2">
                                    {{ $task->updated_at->diffForHumans() }}
                                </p>

                                @if($task->due_date)
                                    <div class="due-date-display mt-1 flex items-center text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 rtl:ml-1 ltr:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $task->due_date->format('Y-m-d') }} <span class="mx-1" style="display: none;">(متأخرة)</span>
                                    </div>
                                @endif

                                <div class="flex justify-end items-center border-t dark:border-gray-700 pt-3 mt-2">
                                    <div class="flex space-x-3 rtl:space-x-reverse items-center">
                                        <button type="button" style="display: none;"
                                            @click="openEdit({{ $task->id }}, $el.dataset.title, $el.dataset.desc, $el.dataset.priority, $el.dataset.duedate)"
                                            data-title="{{ $task->title }}" data-desc="{{ $task->description ?? '' }}"
                                            data-priority="{{ $task->priority }}" data-duedate="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                                            class="edit-btn text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 text-lg flex items-center justify-center pt-1 transition-colors">✎</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="m-0 p-0 flex items-center justify-center">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="delete-btn text-xs bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 font-bold py-1 px-3 rounded-full border border-red-200 dark:border-red-800 transition-colors"
                                                onclick="return confirm('حذف نهائي؟')">حذف 🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-[99999] overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showAddModal" @click="showAddModal = false" x-transition.opacity
                    class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showAddModal" x-transition.scale.95
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form method="POST" action="{{ route('tasks.store') }}" @submit="isSubmitting = true">
                        @csrf
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 transition-colors duration-300">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                                ✨ إضافة مهمة جديدة</h3>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">عنوان المهمة:</label>
                                <input type="text" name="title"
                                    class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">الأولوية:</label>
                                    <select name="priority" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="low">🔵 عادي</option>
                                        <option value="medium">🟡 متوسط</option>
                                        <option value="high">🔴 عاجل</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">تاريخ الاستحقاق (اختياري):</label>
                                    <input type="date" name="due_date" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">التفاصيل (اختياري):</label>
                                <textarea name="description" rows="3"
                                    class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse transition-colors duration-300">
                            <button type="submit" :disabled="isSubmitting"
                                :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                                <span x-show="!isSubmitting">حفظ المهمة</span>
                                <span x-show="isSubmitting">جاري الحفظ...</span>
                            </button>
                            <button type="button" @click="showAddModal = false" :disabled="isSubmitting"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-transparent shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-[99999] overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showEditModal" @click="if(!isSubmitting) showEditModal = false" x-transition.opacity
                    class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showEditModal" x-transition.scale.95
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">

                    <form method="POST" :action="editFormAction" @submit="isSubmitting = true">
                        @csrf
                        @method('PUT')
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 transition-colors duration-300">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                                ✏️ تعديل المهمة</h3>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">عنوان المهمة:</label>
                                <input type="text" name="title" x-model="editTitle"
                                    class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">الأولوية:</label>
                                    <select name="priority" x-model="editPriority" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="low">🔵 عادي</option>
                                        <option value="medium">🟡 متوسط</option>
                                        <option value="high">🔴 عاجل</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">تاريخ الاستحقاق (اختياري):</label>
                                    <input type="date" name="due_date" x-model="editDueDate" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">التفاصيل (اختياري):</label>
                                <textarea name="description" x-model="editDescription" rows="3"
                                    class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse transition-colors duration-300">
                            <button type="submit" :disabled="isSubmitting"
                                :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                                <span x-show="!isSubmitting">حفظ التعديلات</span>
                                <span x-show="isSubmitting">جاري الحفظ...</span>
                            </button>
                            <button type="button" @click="showEditModal = false" :disabled="isSubmitting"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-transparent shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const columns = ['pending', 'in_progress', 'completed'];

            columns.forEach(status => {
                const el = document.getElementById(status);

                new Sortable(el, {
                    group: 'tasks',
                    animation: 150,
                    ghostClass: 'opacity-20',
                    chosenClass: 'shadow-2xl',
                    forceFallback: true,
                    fallbackClass: 'dragging-item-clone',
                    fallbackOnBody: true,
                    fallbackTolerance: 0,
                    swapThreshold: 0.6,

                    onClone: function (evt) {
                        if (evt.clone) {
                            evt.clone.removeAttribute('x-show');
                            evt.clone.style.display = 'block'; 
                        }
                    },

                    onEnd: function (evt) {
                        const itemEl = evt.item;
                        const taskId = itemEl.getAttribute('data-id');
                        const newStatus = evt.to.id;

                        if (evt.from.id === evt.to.id) return;

                        fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        }).then(response => {
                            if (response.ok) {
                                document.getElementById('count-' + evt.from.id).innerText = evt.from.children.length;
                                document.getElementById('count-' + evt.to.id).innerText = evt.to.children.length;

                                const titleEl = itemEl.querySelector('h4');
                                const editBtn = itemEl.querySelector('.edit-btn');
                                const delBtn = itemEl.querySelector('.delete-btn');
                                const badgeEl = itemEl.querySelector('span.text-\\[11px\\]');
                                const dateDiv = itemEl.querySelector('.due-date-display');

                                if (newStatus === 'completed') {
                                    titleEl.classList.add('line-through', 'text-gray-500');
                                    titleEl.classList.remove('text-gray-800', 'dark:text-white');
                                    itemEl.classList.add('opacity-75');
                                    if (badgeEl) badgeEl.classList.add('opacity-50');

                                    if(dateDiv) {
                                        dateDiv.classList.remove('text-red-500', 'dark:text-red-400', 'text-yellow-600', 'dark:text-yellow-500');
                                        dateDiv.classList.add('text-gray-500', 'dark:text-gray-400');
                                        const overdueSpan = dateDiv.querySelector('span.mx-1');
                                        if(overdueSpan) overdueSpan.style.display = 'none';
                                    }

                                    editBtn.style.display = 'none';
                                    delBtn.innerHTML = 'حذف 🗑️';
                                    delBtn.className = 'delete-btn text-xs bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 font-bold py-1 px-3 rounded-full border border-red-200 dark:border-red-800 transition-colors';
                                } else {
                                    titleEl.classList.remove('line-through', 'text-gray-500');
                                    titleEl.classList.add('text-gray-800', 'dark:text-white');
                                    itemEl.classList.remove('opacity-75');
                                    if (badgeEl) badgeEl.classList.remove('opacity-50');

                                    if(dateDiv) {
                                        const overdueSpan = dateDiv.querySelector('span.mx-1');
                                        if(overdueSpan && overdueSpan.innerText.includes('متأخرة')){
                                            dateDiv.classList.remove('text-gray-500', 'dark:text-gray-400');
                                            dateDiv.classList.add('text-red-500', 'dark:text-red-400');
                                        } else if(overdueSpan && overdueSpan.innerText.includes('اليوم')) {
                                            dateDiv.classList.remove('text-gray-500', 'dark:text-gray-400');
                                            dateDiv.classList.add('text-yellow-600', 'dark:text-yellow-500');
                                        }
                                        if(overdueSpan) overdueSpan.style.display = 'inline';
                                    }

                                    editBtn.style.display = 'inline-flex';
                                    delBtn.innerHTML = '✕';
                                    delBtn.className = 'delete-btn text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-lg flex items-center justify-center transition-colors';
                                }
                            }
                        });
                    },
                });
            });
        });
    </script>
</x-app-layout>