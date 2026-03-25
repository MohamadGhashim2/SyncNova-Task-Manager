<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
          $table->id();
            $table->string('title'); // عنوان المهمة
            $table->text('description')->nullable(); // تفاصيل المهمة (جعلناها اختيارية)
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // حالة المهمة
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط المهمة بالمستخدم الذي أنشأها
            $table->timestamps(); // يسجل وقت الإنشاء والتعديل أوتوماتيكياً
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
