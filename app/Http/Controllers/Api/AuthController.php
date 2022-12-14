<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //register
    public function register(Request $request)

    {
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa register admin atau pengurus'
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    
    }

    //login
    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // logout
    public function logout()
    {
        // if data not found error 404
        if (Auth::user() == null) {
            return response([
                'message' => 'data tidak ditemukan'
            ], 404);
        }
        // if data found
        $user = Auth::user()->currentAccessToken()->delete();
    }

    // update user profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . Auth::user()->id
        ]);
        if(Auth::check())
        {
            if($request->input('password'))
            {
                $hashed = Hash::make($request->input('password'));
                $user = User::find(Auth::user()->id);
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = $hashed;
                $user->update();
            }

            $user = User::find(Auth::user()->id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->update();
        }
        return response()->json([
            'message' => 'update success'
        ]);

    }

    // get all user
    public function getAllUser()
    {
        $user = User::all();
        return response()->json([
            'success' => true,
            'message' => 'Data User',
            'data' => $user
        ], 200);
    }

    // delete user only admin
    public function destroy($id)
    {
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa menghapus user'
            ], 403);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data User Tidak Ditemukan',
            ], 404);
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data User Berhasil Dihapus',
        ], 200);
    }
}