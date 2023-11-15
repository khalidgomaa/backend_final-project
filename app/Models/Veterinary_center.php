<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinary_center extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",    "street_address",    "governorate",    "logo",    "about", "license",    "open_at", "close_at",  "tax_record", "commercial_record", "user_id", "status"
    ];
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }
}