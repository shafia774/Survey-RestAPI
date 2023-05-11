<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'age',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => Gender::class,
    ];
}
