<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order__item extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','pet_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
