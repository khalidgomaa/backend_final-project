<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointment = Appointment::all();
        return $appointment;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),[
            "is_confirmed" => "required",
            "user_id" => "required",
            "veternary_id" => "required",
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(),422);
        }
        $appointment = Appointment::create($request->all());
        
        $appointment->save();
        return response()->json(['message'=> $appointment])->setStatusCode(200) ;
  
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
    public function update(Request $request, Appointment $appointment)
    {
         // Validation and updating logic
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
