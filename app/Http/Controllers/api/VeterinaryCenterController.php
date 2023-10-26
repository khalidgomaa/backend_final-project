<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\veterinary_center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VeterinaryCenterResource;

class VeterinaryCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = veterinary_center::all();
        return VeterinaryCenterResource::collection($categories);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $veterinary_center = veterinary_center::create($request->all());
        
        return new VeterinaryCenterResource($veterinary_center);    
    }

    /**
     * Display the specified resource.
     */
    public function show(veterinary_center $veterinary_center)
    {
        return new VeterinaryCenterResource($veterinary_center);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, veterinary_center $veterinary_center)
    {
       
        return new VeterinaryCenterResource($veterinary_center);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(veterinary_center $veterinary_center)
    {
        $veterinary_center->delete();
        return "Deleted Successfully";
        }
}
