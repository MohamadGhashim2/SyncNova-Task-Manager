<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // جلب المهام الخاصة بالمستخدم الذي قام بتسجيل الدخول فقط، وترتيبها من الأحدث للأقدم
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        
        // إرسال المهام إلى صفحة التصميم
        return view('tasks.index', compact('tasks'));
    }
    // دالة لفتح صفحة النموذج
    public function create()
    {
        return view('tasks.create');
    }
    // دالة لاستلام البيانات وحفظها
    public function store(Request $request)
    {
        // 1. التأكد من أن المستخدم أدخل العنوان (حماية)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 2. إنشاء المهمة في قاعدة البيانات
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(), // ربط المهمة بصاحبها
            'status' => 'pending', // الحالة الافتراضية
        ]);

        // 3. العودة إلى صفحة المهام الرئيسية
        return redirect()->route('tasks.index')->with('success', 'تمت إضافة المهمة بنجاح!');    }
    // دالة إكمال المهمة
    public function complete(Task $task)
    {
        // حماية: التأكد من أن المهمة تخص المستخدم الحالي
        if ($task->user_id === Auth::id()) {
            $task->update(['status' => 'completed']);
        }
return redirect()->route('tasks.index')->with('success', 'عاش! تم إنجاز المهمة.'); }

    // دالة حذف المهمة
    public function destroy(Task $task)
    {
        // حماية: التأكد من أن المهمة تخص المستخدم الحالي
        if ($task->user_id === Auth::id()) {
            $task->delete();
        }
return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة!');    }
    // دالة لفتح صفحة التعديل وجلب بيانات المهمة القديمة
    public function edit(Task $task)
    {
        // التأكد من أن المهمة تخص المستخدم نفسه
        if ($task->user_id === Auth::id()) {
            return view('tasks.edit', compact('task'));
        }
return redirect()->route('tasks.index')->with('success', 'تمت العملية بنجاح!');    }

    // دالة لاستلام البيانات المعدلة وحفظها
    public function update(Request $request, Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }
return redirect()->route('tasks.index')->with('success', 'تم تحديث المهمة بنجاح!');
  }
}
