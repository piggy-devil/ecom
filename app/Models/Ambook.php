<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambook extends Model
{
    use HasFactory;

    public function ambookattributes()
    {
        return $this->hasMany('App\Models\AmbookAttribute');
    }
}
