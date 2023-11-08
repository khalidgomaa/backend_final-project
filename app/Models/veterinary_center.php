<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class veterinary_center extends Model
{
    use HasFactory;
    protected $fillable = ["name",	"street_address",	"governorate",	"logo",	"about"	,"license" ,	"open_at" , "close_at" ,  "tax_record"	, "commercial_record" ,	"user_id"	
];
public function doctors()
{
    return $this->hasMany(Doctor::class);
}
}
