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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        $pets = Pet::with('user', 'category')->get();
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
            'category_id' => $request->input('category_id'),
        ]);
         return response()->json(['message' => 'Pet record created successfully'], 201);
    }
    
    

    
    public function show(string $id)
    {
        $pet = Pet::findOrFail($id);


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
            // Get the old image path
            // $oldImagePath = $pet->image;
    
            // Store the new image
            $imagePath = $request->file('image')->store('petimages', 'public');
            $validatedData['image'] = $imagePath;
    
            // Delete the old image if it exists
            // if ($oldImagePath) {
            //     Storage::disk('public')->delete($oldImagePath);
            // }
        } else {
            $imagePath = null;
        }

        // if ($pet->isDirty()) {
        //     $pet->update($validatedData);
        // }

        $pet->update($validatedData);
    
        return response()->json(['message' => 'Pet updated successfully']);
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