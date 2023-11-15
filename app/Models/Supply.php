<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
     
        'user_id',
        'category',
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
