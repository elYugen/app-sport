<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {     
        $users = User::with(['measurements'])->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // create token
        $token = $user->createToken('auth_token')->plainTextToken;

        // send user information and token in response
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['measurements']);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));
    }

    /**
     * Update the gender, age and height of the new user
     */
    public function updatePersonalInformations(Request $request, User $user)
    {
        $request->validate([
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'height' => 'required|numeric'
        ]);
        
        $user->update($request->only(['gender', 'age', 'height']));
        
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['deleted' => 1]);
    }
}
