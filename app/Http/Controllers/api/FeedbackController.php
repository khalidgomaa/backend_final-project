<?php

namespace App\Http\Controllers\api;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    function __construct()
    {
         $this->middleware("auth:sanctum")->only(["store" ,"destroy"]);
         
    }
    public function index()
    {
        $feedbacks = Feedback::with('user')->get();
        return response()->json($feedbacks);
    }

    /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       $request->validate([
           'feedback' => 'required',
           'user_id' => 'required',
       ]);
   
       // Create a new record in the database using mass assignment
       $feedback = Feedback::create($request->only(['feedback', 'user_id']));
   
       // Optionally, you can return the created resource as a response
return response()->json(['message' => 'Resource stored successfully', 'data' => $feedback]);
   }
 
 /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $feedback = Feedback::find($id);
    
      
        if (!$feedback) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    
     
        return response()->json(['message' => 'Resource retrieved successfully', 'data' => $feedback]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
 
      {
    $feedback = Feedback::find($id);

    if (!$feedback) {
        return response()->json(['message' => 'Resource not found'], 404);
    }
       $feedback['status'] = 'confirmed';
       $feedback->update();
       return response()->json(['message' => 'feedback accepted successfully']);
   }

/**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        $feedback->delete();
    
        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
