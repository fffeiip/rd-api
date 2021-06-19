<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(\Illuminate\Support\Str::random(40));
            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);
            return response()->json(['status' => 'success', 'api_token' => $apikey, 'user_id' => $user->id]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            'password_confirm' => 'required|same:password'
        ]);
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. ' . $e->getMessage(), 404);
        }
        $user->update($request->all());
        return response()->json($user);
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. ' . $e->getMessage(), 404);
        }
        $user->delete();
        return response()->json(['message' => 'Successfully deleted register', 'user' => $user]);
    }
}
