<?php

namespace App\Model;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class veterinary_center extends Model
{
    use HasFactory;

    function doctor(){
    return $this->hasMany(Doctor::class);
}
}

