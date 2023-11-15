<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetResource;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Http\Requests\storePet;
use App\Http\Requests\updatePet;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
   function __construct()
   {
        $this->middleware("auth:sanctum")->only(["store" ,"update","destroy"]);
        
   }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pets = Pet::with('user')->get();
        return response()->json($pets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storePet $request, Pet $pet)
    {

        $validator = Validator::make($request->all(), $request->rules());

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('petimages', 'public');
        } else {
            $imagePath = null;
        }

        $pet = Pet::create([
            'age' => $request->input('age'),
            'type' => $request->input('type'),
            'gender' => $request->input('gender'),
            'image' => $imagePath,
            'price' => $request->input('price'),
            'operation' => $request->input('operation'),
            'user_id' => $request->input('user_id'),
            'category' => $request->input('category'),
        ]);
        return response()->json(['message' => 'Pet record created successfully'], 201);
    }

    
   
      public function show(string $id)
{
    $pet = Pet::with('user')->findOrFail($id);

    return response()->json($pet);
}




    /**
     * Update the specified resource in storage.
     */
    public function update(updatePet $request, string $id)
    {
        $pet = Pet::findOrFail($id);
        $validatedData = $request->validate($request->rules());
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('petimages', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            $imagePath = null;
        }

        $pet->update($validatedData);
    
        return response()->json(['message' => 'Pet updated successfully','pet'=>$pet,'validation data'=>$validatedData]);
    }  
    
    
    

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        // Delete the image from the folder if it exists
        if ($pet->image) {
            $imagePath = public_path('storage/' . $pet->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the pet record
        $pet->delete();

        return response()->json(null, 204);
    }
}
