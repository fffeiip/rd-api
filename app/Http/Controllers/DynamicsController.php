<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Dynamics;

class DynamicsController extends Controller
{
    public function show($id)
    {
        return response()->json(Dynamics::findOrFail($id));
    }
    public function showAll()
    {
        return response()->json(Dynamics::paginate(10));
    }

    public function create(Request $request) {
        $this->validate($request, [
            "name" => "required",
            "description" => "required|max:255"
        ]);

        $dynamics = Dynamics::create($request->all());
        return response()->json($dynamics,201);
    }

    public function update($id, Request $request) {
        try {
            $dynamics = Dynamics::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $dynamics->update($request->all());
        return response()->json($dynamics);
    }

    public function delete($id) {
        try {
            $dynamics = Dynamics::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $dynamics->delete();
        return response()->json(['message' => 'Successfully deleted register', 'dynamic' => $dynamics]);
    }
}
