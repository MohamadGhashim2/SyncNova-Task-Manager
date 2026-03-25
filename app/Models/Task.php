<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // الحقول المسموح بتعبئتها
    protected $fillable = ['title', 'description', 'status', 'user_id'];

    // علاقة: كل مهمة تنتمي لمستخدم واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}