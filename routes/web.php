<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// لوحة التحكم
Route::get('/dashboard', function () {
    // جلب إحصائيات المستخدم الحالي فقط
    $userId = auth()->id();
    
    $totalTasks = \App\Models\Task::where('user_id', $userId)->count();
    $completedTasks = \App\Models\Task::where('user_id', $userId)->where('status', 'completed')->count();
    $pendingTasks = \App\Models\Task::where('user_id', $userId)->where('status', 'pending')->count();

    // إرسال الأرقام إلى صفحة التصميم
    return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 🌟 مسار المهام الخاص بنظام SyncNova 🌟
Route::get('/tasks', [TaskController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->middleware(['auth', 'verified'])->name('tasks.create');
// مسار لتغيير حالة المهمة إلى "مكتملة"
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->middleware(['auth', 'verified'])->name('tasks.complete');
// مسار لفتح صفحة التعديل
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->middleware(['auth', 'verified'])->name('tasks.edit');

// مسار لحفظ التعديلات الجديدة
Route::put('/tasks/{task}', [TaskController::class, 'update'])->middleware(['auth', 'verified'])->name('tasks.update');
// مسار لحذف المهمة
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tasks.destroy');
Route::post('/tasks', [TaskController::class, 'store'])->middleware(['auth', 'verified'])->name('tasks.store');
// مسارات الملف الشخصي للمستخدم
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// هذا السطر السحري الذي يجلب كل مسارات تسجيل الدخول والخروج!
require __DIR__.'/auth.php';