<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\EmailAppointment;
use App\Mail\RejectMail;
use App\Models\Appointment;
use App\Models\Veterinary_center;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function accept()
    {
        $appointment = Appointment::with('user')->first();
        Mail::to($appointment->user->email)->send(new EmailAppointment());
        return response()->json("appointment success");
    }

    public function reject()
    {
        $appointment = Appointment::with('user')->first();
        Mail::to($appointment->user->email)->send(new RejectMail());
        return response()->json("appointment Reject");
    }
}
