<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;



class CategoryController extends Controller
{

    // function __construct(){

    //     $this->middleware("auth:sanctum")->only(['store']);
    //   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => [Rule::unique('Categories')],
            "desc" => "required",
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->all(), 402);
        }

        $Category = Category::create($request->all());
        
        return new CategoryResource($Category);    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->all(), 402);
        }

        $category->update($request->all());
        return new CategoryResource($category);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return "Deleted Successfully";    }
}
