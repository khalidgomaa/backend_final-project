<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreDoctor;
use App\Http\Requests\UpdateDoctor;
use Illuminate\Validation\Rule;
use App\Http\Resources\DoctorResource;
use Illuminate\Support\Facades\Gate;


class DoctorController extends Controller
{


    function __construct()
    {
        $this->middleware("auth:sanctum")->only(["store" ,"update"]);
        
    }
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
    public function store(StoreDoctor $request ,Doctor $doctor)
    {
        $validator = Validator::make($request->all(), $request->rules());
        

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctorimages', 'public');
        } else {
            $imagePath = null;
        }
        
        if (Gate::allows(["is_admin", "is_owner"])) {
        $doctor = Doctor::create([
            'name' => $request->input('name'),
            'experience' => $request->input('experience'),
            'image' => $imagePath,
            'veterinary_center_id'=>$request->input('veterinary_center_id')
        ]);
        }
        return response()->json(['message'=> "not Authorize"]);
  

        return new DoctorResource($doctor);
        return response()->json(['message' => 'doctor record created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    
    public function update(UpdateDoctor $request,string $id)
    {
      
       $doctor=Doctor::findOrFail($id); 
        $validateData=$request->validate($request->rules());
        //handle image file
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('doctorimages','public');
            $validateData['image']=$imagePath;
        }
        else
        {
            //handle if no image 
            $imagePath['image']=null;
        }
        

            $doctor->update( $validateData);
         
            
    //return response()->json(['message' => 'doctor updated successfully']);
         return new DoctorResource($doctor);
    }

   
    public function destroy($id){
    $doctor=Doctor::find($id);
    if (!$doctor) {
        return response()->json(['error' => 'doctor not found'], 404);
    }

    // Delete the image from the folder if it exists
    if ($doctor->image) {
        $imagePath = public_path('storage/' . $doctor->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    if (Gate::allows(["is_admin", "is_owner"])) {
       //delete doctor
       $doctor->delete();
       return "deleted successfully";
    }
        return response()->json(['message'=> "not Authorize"]);
    

    }
}
