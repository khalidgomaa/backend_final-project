<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        // dd($validatedData);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('CategoryImage', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            $validatedData['image'] = null;
        }

        $Category = Category::create(['image' => $imagePath, 'name' => $request->input('name'), 'desc' => $request->input('desc')]);
        return new CategoryResource($Category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category, string $id)
    {
        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('CategoryImage', 'public');
            $category->update(['image' => $imagePath]);
        }

        // Update other fields
        $category->update([
            'name' => $request->input('name', $category->name),
            'desc' => $request->input('desc', $category->desc),
        ]);
        $category->update(['name' => $request->input('name'), 'desc' => $request->input('desc')]);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->image) {
                $imagePath = public_path('storage/' . $category->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $category->delete();
            return "Deleted Successfully";
        } else {
            return "Already Deleted";
        }
    }
}
