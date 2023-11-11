<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Sanctum;

class UsersController extends Controller
{

    public function register(UsersRequest $data)
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

        // Check if the user was created successfully
        if ($user) {
            return $user;
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['message' => 'Login successful', 'access_token' => $token], 200);
    }

    public function logout(User $user)
    {
        $user = Auth::guard('sanctum')->user();

        $token = $user->currentAccessToken();
        $token->delete();

        return response("Logout", 200);
    }

    public function update(Request $request)
    {
        // Ensure the user is authenticated
        // if (!Auth::check()) {
        //     return response()->json(["error" => "User not authenticated"], 401);
        // }
    
        $user = Auth::user();
    
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'old_password' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' checks for password_confirmation field
        ]);
    
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return response()->json(["error" => "The old password is not valid"], 422);
        }
    
        // Update user's profile
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
    
        // Check if a new password is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        return response()->json(["message" => "Updated successfully"], 200);
    }
    

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

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
}
