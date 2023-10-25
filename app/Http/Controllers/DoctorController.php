<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\DoctorResource;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor=Doctor::all();
        return DoctorResource::collection($doctor);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,Doctor $doctor)
    {
        $validator=Validator::make($request->all(),
        [
          "name"=>"required",
          "image"=>"required"
          
        ]);
        if($validator ->fails()){
            return response($validator->errors()->all(),422);
        }
        
        try {
            $createdoctor=$doctor->create($request->all());
            
        return new DoctorResource($createdoctor);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Doctor $doctor )
    {

        $validator=Validator::make($request->all(),
        [
          "name"=>"required",
          "image"=>"required"
          
        ]);
        if($validator ->fails()){
            return response($validator->errors()->all(),422);
        }

        
         
            $doctor->update( $request->all());
         
            
    
         return new DoctorResource($doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return "deleted successfully";
    }
}
