<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'device_info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
