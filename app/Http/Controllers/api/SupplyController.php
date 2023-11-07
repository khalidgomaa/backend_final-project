<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use App\Models\Supply;

class SupplyController extends Controller
{
    // List all supplies
    public function index()
    {
        $supplies = Supply::with('user')->get();
        return response()->json($supplies);
    }

    // Show a specific supply
    public function show($id)
    {
        return Supply::find($id);
    }

    // Create a new supply
    // public function store(Request $request)
    // {
    //     // Validation and saving logic
    // }
    public function store(storeSupply $request, Supply $supply)
    {
    
    $validator = Validator::make($request->all(), $request->rules());

    // if ($validator->fails()) {
    //     return response()->json(['errors' => $validator->errors()], 400);
    // }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('supplyimages', 'public');
        } else {
            $imagePath = null;
        }
    
        $supply = Supply::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'quantity' => $request->input('quantity'),
            'is_available' => $request->input('is_available'),
            'user_id' => $request->input('user_id'),
        ]);
         return response()->json(['message' => 'Supply record created successfully'], 201);
    }

    // Edit an existing supply
    public function update(Request $request, $id)
    {
        // Validation and updating logic
    }

    // Delete a supply
    public function destroy($id)
    {
        // Deletion logic
    }
}
