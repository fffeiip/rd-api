<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function show($id)
    {
        return response()->json(Team::findOrFail($id));
    }

    public function create(Request $request) {
        $this->validate($request, [
            "team_leader" => "required|string|min:36|max:36",
            "name" => "required|string|max:255"
        ]);
        $team = Team::create($request->all());
        return response()->json($team,201);
    }

    public function update($id, Request $request) {
        try {
            $team = Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $team->update($request->all());
        return response()->json($team);
    }

    public function delete($id) {
        try {
            $team = Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $team->delete();
        return response()->json(['message' => 'Successfully deleted register', 'team' => $team]);
    }

}
