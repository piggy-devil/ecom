<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amuletmodel extends Model
{
    use HasFactory;

    public function amuletbooks()
    {
        return $this->hasMany('App\Models\Ambook', 'ammodel_id', 'id');
    }
}
