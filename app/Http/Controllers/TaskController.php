<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',  
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date, 
            'user_id' => Auth::id(),
            'status' => 'pending', 
        ]);

        return redirect()->route('tasks.index')->with('success', 'تمت إضافة المهمة بنجاح!');
    }

    public function complete(Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $task->update(['status' => 'completed']);
        }
        return redirect()->route('tasks.index')->with('success', 'عاش! تم إنجاز المهمة.');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $task->delete();
        }
        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة!');
    }

    public function edit(Task $task)
    {
        if ($task->user_id === Auth::id()) {
            return view('tasks.edit', compact('task'));
        }
        return redirect()->route('tasks.index')->with('success', 'تمت العملية بنجاح!');
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'priority' => 'required|in:low,medium,high',
                'due_date' => 'nullable|date', 
            ]);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'due_date' => $request->due_date, 
            ]);
        }
        return redirect()->route('tasks.index')->with('success', 'تم تحديث المهمة بنجاح ✏️');
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $task->update(['status' => $request->status]);
        }
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('tasks.index')->with('success', 'تم نقل المهمة بنجاح 🚀');
    }
}