<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'admin';
    protected $fillable = [
        'name', 'email', 'password', 'type', 'mobile', 'image', 'status', 'created_at', 'updated_at'
    ];
    protected $hidden = [
        'password', 'remember_token'
    ];
}
