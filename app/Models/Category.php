<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;



    public function Pets()
    {
        return $this->hasMany(Pets::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
