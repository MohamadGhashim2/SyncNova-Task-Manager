<div data-id="{{ $task->id }}"
     data-search="{{ htmlspecialchars($task->title . ' ' . ($task->description ?? ''), ENT_QUOTES) }}"
     x-show="searchQuery === '' || $el.dataset.search.toLowerCase().includes(searchQuery.toLowerCase())"
     x-transition.opacity.duration.300ms
     class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm cursor-grab active:cursor-grabbing hover:shadow-lg transition-shadow duration-150 ease-in-out relative 
     {{ $task->status == 'completed' ? 'opacity-75 hover:opacity-100 border-r-4 border-transparent hover:border-green-400 dark:hover:border-green-500' : 'hover:border-2 ' . ($task->status == 'pending' ? 'hover:border-yellow-400' : 'hover:border-blue-400') }}">

    <div class="absolute top-3 left-3 rtl:right-3 rtl:left-auto">
        <span class="text-[11px] px-2 py-1 rounded-md font-bold shadow-sm border {{ $task->status == 'completed' ? 'opacity-50' : '' }}
            {{ $task->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400 dark:border-red-800' : '' }}
            {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-400 dark:border-yellow-800' : '' }}
            {{ $task->priority == 'low' ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-400 dark:border-blue-800' : '' }}
        ">
            @if($task->priority == 'high') 🔴 {{ __('messages.high') }}
            @elseif($task->priority == 'medium') 🟡 {{ __('messages.medium') }}
            @else 🔵 {{ __('messages.low') }} @endif
        </span>
    </div>

    <h4 class="font-bold text-lg mt-4 {{ $task->status == 'completed' ? 'text-gray-500 dark:text-gray-400 line-through' : 'text-gray-800 dark:text-white' }}">
        {{ $task->title }}
    </h4>

    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 mb-2">
        {{ $task->created_at->diffForHumans() }}
    </p>

    @if($task->due_date)
        @php
            $dueDate = \Carbon\Carbon::parse($task->due_date)->endOfDay();
            $now = \Carbon\Carbon::now();
            $isOverdue = $dueDate->isPast();
            $daysLeft = $now->diffInDays($dueDate, false);

            if ($isOverdue) {
                $timeText = __('messages.overdue') ?? 'متأخرة'; // تأكد من إضافة overdue لملفات اللغة
                $colorClass = 'text-red-500 dark:text-red-400';
            } elseif ($daysLeft == 0) {
                $timeText = __('messages.today') ?? 'اليوم';
                $colorClass = 'text-yellow-600 dark:text-yellow-500';
            } elseif ($daysLeft == 1) {
                $timeText = __('messages.tomorrow') ?? 'غداً';
                $colorClass = 'text-gray-500 dark:text-gray-400';
            } else {
                $timeText = (app()->getLocale() == 'ar' ? 'متبقي ' : '') . intval($daysLeft) . (app()->getLocale() == 'ar' ? ' أيام' : ' days left');
                $colorClass = 'text-gray-500 dark:text-gray-400';
            }
        @endphp
        <div class="due-date-display mt-1 flex items-center text-xs font-semibold {{ $task->status == 'completed' ? 'text-gray-500 opacity-50' : $colorClass }}">
            <svg class="w-4 h-4 rtl:ml-1 ltr:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $task->due_date->format('Y-m-d') }} 
            @if($task->status != 'completed')
                <span class="mx-1">({{ $timeText }})</span>
            @endif
        </div>
    @endif

    <div class="flex justify-end items-center border-t dark:border-gray-700 pt-3 mt-2">
        <div class="flex space-x-3 rtl:space-x-reverse items-center">
            @if($task->status != 'completed')
                <button type="button"
                    @click="openEdit({{ $task->id }}, $el.dataset.title, $el.dataset.desc, $el.dataset.priority, $el.dataset.duedate)"
                    data-title="{{ $task->title }}" 
                    data-desc="{{ $task->description ?? '' }}"
                    data-priority="{{ $task->priority }}"
                    data-duedate="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                    class="edit-btn text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 text-lg transition-colors">✎</button>
            @endif

            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="m-0 p-0">
                @csrf @method('DELETE')
                <button type="submit"
                    class="{{ $task->status == 'completed' ? 'text-xs bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 font-bold py-1 px-3 rounded-full border border-red-200 dark:border-red-800' : 'text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-lg' }} transition-colors"
                    onclick="return confirm('{{ $task->status == 'completed' ? __('messages.confirm_delete_final') : __('messages.confirm_delete') }}')">
                    {{ $task->status == 'completed' ? __('messages.delete') . ' 🗑️' : '✕' }}
                </button>
            </form>
        </div>
    </div>
</div>