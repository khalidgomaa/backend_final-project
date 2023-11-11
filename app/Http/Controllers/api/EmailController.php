<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\EmailAppointment;
use App\Mail\RejectMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function accept(){
        Mail::to(Auth::user()->email)->send(new EmailAppointment());
        return response()->json("appointment success");

    }
    public function reject(){
        Mail::to(Auth::user()->email)->send(new RejectMail());
        return response()->json("appointment Reject");
    }
}
