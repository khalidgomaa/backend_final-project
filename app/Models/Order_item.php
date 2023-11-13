<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','pet_id','supply_id','quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class);
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
