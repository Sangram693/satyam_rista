<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Salesman;
use App\Models\SuperAdmin;
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
        
        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ],[
            'user_name.required'=>'User Name is required',
            'password.required'=>'Password is required'
        ]);

        
        $salesPerson = SalesPerson::where('user_name', $credentials['user_name'])->first();
        
        
        
        

        if ($salesPerson && Hash::check($credentials['password'], $salesPerson->password)) {
            
            $token = $salesPerson->createToken('auth_token')->plainTextToken;

            // return $salesPerson->role;

            switch ($salesPerson->role) {
                case 'super_admin':
                    $user = SuperAdmin::where('email', $salesPerson->email)->first();
                    break;
                    
                    case 'admin':
                        $user = Admin::where('email', $salesPerson->email)->first();
                        break;

                        case 'salesman':
                            $user = Salesman::where('email', $salesPerson->email)->first()
                            ->makeHidden(['admin_id', 'created_by', 'updated_by'])->load('admin', 'dealerDistributors', 'zone', 'creator', 'updater');
                            break;
                
                default:
                    $user = null;
                    break;
            }

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'role' => $salesPerson->role,
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // return response()->json($request->user());

        return response()->json(['message' => 'Logout successful']);
    }
}
