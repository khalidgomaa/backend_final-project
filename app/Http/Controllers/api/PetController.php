<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Http\Requests\PetRequest;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::all();
        return response()->json($pets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetRequest $request)
    {
        // Validate the incoming request data using the PetRequest class
        $validatedData = $request->validated();

        // Handle the image file upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('petimages', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            // Handle the case when no image is provided
            $validatedData['image'] = null;
        }

        // Create a new pet record and save it to the database
        $pet = Pet::create($validatedData);

        return response()->json(['message' => 'Pet record created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        return response()->json($pet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PetRequest $request, string $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        // Validate the incoming request data using the PetRequest class
        $validatedData = $request->validated();

        // Handle the image file upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('petimages', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            // Handle the case when no image is provided
            $validatedData['image'] = null;
        }

        // Update the pet with the validated data
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