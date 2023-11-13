<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Veterinary_center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // Auth::guard('sanctum')->user()->id
    //     // $appointments = Appointment::with('veterinary')->get();

    //     $veterinary = Veterinary_center::select('id')->get();
    //     return response()->json($veterinary['id']);
    // }

    public function index()
    {
        $user = Auth::guard('sanctum')->user()->id;
        $firstVeterinaryId = Veterinary_center::where('user_id', $user)->first()->id;
        $appointments = Appointment::with('user')->where('veternary_id', $firstVeterinaryId)->get();
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "pet_type" => "required",
                "date" => 'required|after_or_equal:' . date('Y-m-d'),
                "time" => "required",
                "user_id" => "required",
                "veternary_id" => "required",
            ]
        );

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
        $appointment = Appointment::create($request->all());
        $appointment->save();
        return response()->json(['message' => $appointment])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return $appointment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateaccept(Appointment $appointment)
    {
        $appointment['status'] = 'accepted';
        $appointment->update();
        return response()->json(['message' => 'Update accepted successfully']);
    }

    public function updatereject(Appointment $appointment)
    {
        $appointment['status'] = 'rejected';
        $appointment->update();
        return response()->json(['message' => 'Update rejected successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // $appointment->delete();
        // return response()->json(['message'=> "Deleted Successfully"])->setStatusCode(201);

    }
}
