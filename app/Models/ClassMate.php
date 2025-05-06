<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMate extends Model
{
    use HasFactory;

    protected $primaryKey = 'class_id';

    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_in_class', 'class_id', 'user_id');
    }
}
