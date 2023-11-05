<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Sanctum;
class UsersController extends Controller
{



    public function register(Request $data)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    
        // Validate the incoming data
        $validatedData = $data->validate($rules);
    
        // If validation fails, Laravel will automatically redirect back with errors
    
        // If validation passes, create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);
    
        // Check if user was created successfully
        if ($user) {
            return $user;
        }
    
        return abort(404);
    }
    

    /**
     * Display the specified resource.
     */
    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'device_name' => 'required',
        ]);
        
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['message' => 'Login successful', 'access_token' => $token], 200);    }

    public function logout(User $user)
    {
        $user = Auth::guard('sanctum')->user();
      
        $token = $user->currentAccessToken();
        // dd($token);
        $token->delete();
        return response("Logout" , 200);
      
        }

    // public function logout(Request $request)
    // {
    //     $user = $request->user();
    //     $user->tokens->each(function ($token, $key) {
    //         $token->delete();
    //     });
    
    //     return response("Logout successful", 200);
    // }
    


    public function getuser(Request $request)
    {
        $user = $request->user();
    
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
    
        return response()->json($userData, 200);
    }






    /**
     * Display a listing of the resource.
     */
   public function index()
  {
    $users=User::all();
            return response()->json($users);
     }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(User $user)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, User $user)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(User $user)
    // {
    //     //
    // }
}
