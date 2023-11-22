<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'image', 'experience',
      'veterinary_center_id'
    ];

    public function veterinary_center()
    {
        return $this->belongsTo(Veterinary_center::class);
    }
}