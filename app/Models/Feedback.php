<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = ['feedback','user_id'];
    protected $table = 'feedbacks';

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
