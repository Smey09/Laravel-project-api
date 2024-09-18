<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate request
        $valiator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        if ($valiator->fails()) {
            return response()->json($valiator->errors(), 400);
        }
        $data = $request->all(); // get all request data
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $distinationPath = public_path('/users');
            $image->move($distinationPath, $name);
            $data['profile_pic'] = '/users/' . $name;
        }
        $data['password'] = bcrypt($data['password']); // encrypt password
        $user = User::create($data);
        return response()->json(
            ['message' => 'User created successfully', 'user' => $user]
        );
    }
    public function login(Request $request)
    {
        // validate request
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // attempt login
        if (!auth()->attempt($data)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = auth()->user()->createToken('authToken')->accessToken;
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => auth()->user(),
            'token' => $token
        ]);
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $user = Auth::user(); // get current logged in user
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $distinationPath = public_path('/users');
            $image->move($distinationPath, $name);
            $data['profile_pic'] = '/users/' . $name;

            $oldImage = $user->profile_pic;
            if ($oldImage) {
                $oldImage = public_path('') . $oldImage;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                };
            }
        }
        $user->update($data);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    public function destroy()
    {
        $user = Auth::user(); /// get current logged in user
        if ($user != null) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }
        return response()->json(['message' => 'User not found']);
    }
    public function me()
    {
        return response()->json([
            'user' => Auth::user(),
        ]);
    }
}
