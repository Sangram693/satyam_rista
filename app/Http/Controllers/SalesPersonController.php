<?php

namespace App\Http\Controllers;

use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SalesPersonController extends Controller
{
    /**
     * Handle the login for SalesPerson (super_admin, admin, salesman).
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ],[
            'user_name.required'=>'User Name is required',
            'password.required'=>'Password is required'
        ]);

        // Attempt to log in with user_name and password
        $salesPerson = SalesPerson::where('user_name', $credentials['user_name'])->first();
        // return response()->json([
        //     'message' => 'Login successful',
        //     'user' => $salesPerson,
        // ]);

        if ($salesPerson && Hash::check($credentials['password'], $salesPerson->password)) {
            // Generate a token for the authenticated user
            $token = $salesPerson->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $salesPerson,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
