<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Users;
use App\Models\LinkTeamUser;

class LinkTeamUserController extends Controller
{
    public function showTeamsByUser($id)
    {
        $response = LinkTeamUser::where('user', $id)
            ->orderBy('created_at')
            ->paginate(10);

        return response()->json($response);
    }

    public function showUsersByTeam($id)
    {
        $response = LinkTeamUser::where('team', $id)
            ->orderBy('created_at')
            ->paginate(10);

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|string|max:36|min:36',
            'team' => 'required|string|max:36|min:36',
        ]);
        $response = LinkTeamUser::create($request->all());
        return response()->json($response, 201);
    }

    public function show($id)
    {
        return response()->json(LinkTeamUser::findOrFail($id));
    }

    public function delete($id)
    {
        try {
            $link_teams_user = LinkTeamUser::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. ' . $e->getMessage(), 404);
        }
        $link_teams_user->delete();
        return response()->json(['message' => 'Successfully deleted register', 'register' => $link_teams_user]);
    }
}
