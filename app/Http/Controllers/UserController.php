<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function create(Request $request) {
        $user = User::create($request->all());
        return response()->json($user,201);
    }

    public function update($id, Request $request) {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $user->update($request->all());
        return response()->json($user);
    }

    public function delete($id) {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $user->delete();
        return response()->json(['message' => 'Successfully deleted register', 'user' => $user]);
    }
}
