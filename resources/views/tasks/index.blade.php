<style>
    .dragging-item-clone {
        display: block !important;
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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.tasks_management') }} SyncNova
            </h2>
        </div>
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

            <div class="mb-6 flex flex-col md:flex-row justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm transition-colors duration-300 gap-4">
                
                <div class="w-full md:w-1/2 relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors" placeholder="{{ __('messages.search_placeholder') }}">
                </div>

                <button @click="showAddModal = true; isSubmitting = false;"
                    class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
                    + {{ __('messages.add_task') }}
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-yellow-400 dark:border-yellow-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>⏳ {{ __('messages.pending') }}</span>
                        <span id="count-pending" class="bg-yellow-200 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'pending')->count() }}</span>
                    </h3>

                    <div id="pending" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'pending') as $task)
                            @include('tasks.partials.task-card', ['status' => 'pending'])
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-blue-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>🚀 {{ __('messages.in_progress') }}</span>
                        <span id="count-in_progress" class="bg-blue-200 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                    </h3>

                    <div id="in_progress" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'in_progress') as $task)
                            @include('tasks.partials.task-card', ['status' => 'in_progress'])
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-4 shadow-inner border-t-4 border-green-500 transition-colors duration-300">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4 border-b dark:border-gray-600 pb-2 flex justify-between items-center">
                        <span>✅ {{ __('messages.completed') }}</span>
                        <span id="count-completed" class="bg-green-200 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </h3>

                    <div id="completed" class="min-h-[200px] space-y-3">
                        @foreach($tasks->where('status', 'completed') as $task)
                            @include('tasks.partials.task-card', ['status' => 'completed'])
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-[99999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showAddModal" @click="showAddModal = false" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showAddModal" x-transition.scale.95 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form method="POST" action="{{ route('tasks.store') }}" @submit="isSubmitting = true">
                        @csrf
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 transition-colors duration-300">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">✨ {{ __('messages.add_task') }}</h3>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.title') }}:</label>
                                <input type="text" name="title" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.priority') }}:</label>
                                    <select name="priority" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="low">🔵 {{ __('messages.low') }}</option>
                                        <option value="medium">🟡 {{ __('messages.medium') }}</option>
                                        <option value="high">🔴 {{ __('messages.high') }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.due_date') }}:</label>
                                    <input type="date" name="due_date" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.description') }}:</label>
                                <textarea name="description" rows="3" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 flex {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : 'flex-row' }} transition-colors duration-300">
                            <button type="submit" :disabled="isSubmitting" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:mx-3 sm:w-auto sm:text-sm">
                                <span x-show="!isSubmitting">{{ __('messages.save') }}</span>
                                <span x-show="isSubmitting">...</span>
                            </button>
                            <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-transparent shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:mx-3 sm:w-auto sm:text-sm">{{ __('messages.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-[99999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showEditModal" @click="if(!isSubmitting) showEditModal = false" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showEditModal" x-transition.scale.95 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form method="POST" :action="editFormAction" @submit="isSubmitting = true">
                        @csrf
                        @method('PUT')
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 transition-colors duration-300">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">✏️ {{ __('messages.tasks_management') }}</h3>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.title') }}:</label>
                                <input type="text" name="title" x-model="editTitle" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.priority') }}:</label>
                                    <select name="priority" x-model="editPriority" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="low">🔵 {{ __('messages.low') }}</option>
                                        <option value="medium">🟡 {{ __('messages.medium') }}</option>
                                        <option value="high">🔴 {{ __('messages.high') }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.due_date') }}:</label>
                                    <input type="date" name="due_date" x-model="editDueDate" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('messages.description') }}:</label>
                                <textarea name="description" x-model="editDescription" rows="3" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-white bg-white dark:bg-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 flex {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : 'flex-row' }} transition-colors duration-300">
                            <button type="submit" :disabled="isSubmitting" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:mx-3 sm:w-auto sm:text-sm">
                                <span>{{ __('messages.save') }}</span>
                            </button>
                            <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-transparent shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:mx-3 sm:w-auto sm:text-sm">{{ __('messages.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        // الكود المتبقي من الجافاسكربت لم يتغير لضمان استقرار السحب والإفلات
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
                                // تحديث الأشكال (مكتملة/غير مكتملة) كما في كودك الأصلي
                                location.reload(); // إعادة التحميل لضمان تطبيق الترجمات والحالات بدقة
                            }
                        });
                    },
                });
            });
        });
    </script>
</x-app-layout>