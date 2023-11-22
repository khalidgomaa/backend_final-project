<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['pet_type', 'time', 'date', 'user_id', 'veternary_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function veterinary()
    {
        return $this->belongsTo(Veterinary_center::class);
    }
}
