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
use App\Http\Resources\VeterinaryCenterResource;
use App\Models\Veterinary_center;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware("auth:sanctum")->only(["store", "update", "destroy"]);
    }

    public function index()
    {
        $doctors = Doctor::with('veterinary_center')->get();
        return response()->json($doctors);
    }

    public function mycenterdoctor()
    {
        $user = Auth::guard('sanctum')->user()->id;
        $firstVeterinaryId = Veterinary_center::where('user_id', $user)->first()->id;
        // $appointments = Appointment::with('user')->where('veternary_id', $firstVeterinaryId)->get();
        $firstVeterinaryId = Veterinary_center::with('doctors')->where('user_id', $firstVeterinaryId)->get();

        // dd($firstVeterinaryId);
        // $appointments = Doctor::where('veterinary_center_id', $firstVeterinaryId)->get();
        // $firstVeterinaryId = Veterinary_center::where('user_id',)->first()->id;
        // $appointments = Doctor::all();
        return response()->json($firstVeterinaryId);
        // return VeterinaryCenterResource::collection($firstVeterinaryId);
    }

    public function currentcenterdoctor()
    {
        // $user = Auth::guard('sanctum')->user()->id;
        // $firstVeterinaryId = Veterinary_center::where('user_id', $user)->first()->id;
        // $appointments = Appointment::with('user')->where('veternary_id', $firstVeterinaryId)->get();
        $firstVeterinaryId = Doctor::with('Veterinary')->where('id', 'veterinary_center_id')->get();

        // dd($firstVeterinaryId);
        // $appointments = Doctor::where('veterinary_center_id', $firstVeterinaryId)->get();
        // $firstVeterinaryId = Veterinary_center::where('user_id',)->first()->id;
        // $appointments = Doctor::all();
        return response()->json($firstVeterinaryId);
        // return VeterinaryCenterResource::collection($firstVeterinaryId);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctor $request, Doctor $doctor)
    {
        $validator = Validator::make($request->all(), $request->rules());


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctorimages', 'public');
        } else {
            $imagePath = null;
        }

        $doctor = Doctor::create([
            'name' => $request->input('name'),
            'experience' => $request->input('experience'),
            'image' => $imagePath,
             'veterinary_center_id' => $request->input('veterinary_center_id')
        ]);
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


    public function update(UpdateDoctor $request, string $id)
    {

        $doctor = Doctor::findOrFail($id);
        $validateData = $request->validate($request->rules());
        //handle image file
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctorimages', 'public');
            $validateData['image'] = $imagePath;
        } else {
            $imagePath['image'] = null;
        }


        $doctor->update($validateData);


        return response()->json(['message' => 'doctor updated successfully']);
        // return new DoctorResource($doctor);
    }


    // public function destroy($id)
    // {
    //     $user = Auth::guard('sanctum')->user()->id;
    //     $firstVeterinaryId = Veterinary_center::where('user_id', $user)->first()->id;
    //     // // $appointments = Appointment::with('user')->where('veternary_id', $firstVeterinaryId)->get();
    //     $doctor = Veterinary_center::with('doctors')->where('user_id', $firstVeterinaryId)->get();
    //     // $doctor = Veterinary_center::find($id);
    //     dd($doctor);
    //     // $doctor = Doctor::find($id);
    //     if (!$doctor) {
    //         return response()->json(['error' => 'doctor not found'], 404);
    //     }

    //     // Delete the image from the folder if it exists
    //     if ($doctor->image) {
    //         $imagePath = public_path('storage/' . $doctor->image);
    //         if (file_exists($imagePath)) {
    //             unlink($imagePath);
    //         }
    //     }
    //     //delete doctor
    //     $doctor->delete();
    //     return "deleted successfully";
    // }
    public function destroy($id, $doctorId)
    {
        $user = Auth::guard('sanctum')->user()->id;

        // Find the veterinary center
        $veterinaryCenter = Veterinary_center::where('user_id', $user)->find($id);

        if (!$veterinaryCenter) {
            return response()->json(['error' => 'Veterinary center not found'], 404);
        }

        // Find the doctor within the veterinary center's doctors relationship
        $doctor = $veterinaryCenter->doctors()->find($doctorId);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        // Delete the image from the folder if it exists
        if ($doctor->image) {
            $imagePath = public_path('storage/' . $doctor->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the doctor
        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }

    public function adminDeleteDoctor($id, Request $request)
    {
        $doctor = Doctor::find($id);
    
        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }
    
        // Delete the image from the folder if it exists
        if ($doctor->image) {
            $imagePath = public_path('storage/' . $doctor->image);
    
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Perform the actual deletion
        $doctor->delete();
    
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
    
}