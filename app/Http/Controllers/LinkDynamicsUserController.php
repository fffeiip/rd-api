<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Dynamics;
use App\Models\Users;
use App\Models\LinkDynamicsUser;


class LinkDynamicsUserController extends Controller
{
    public function showDynamicsByUser($id)
    {
        $response = LinkDynamicsUser::where('participant', $id)
            ->orderBy('created_at')
            ->paginate(10);

        return response()->json($response);
    }

    public function showUserCreatedDynamics($id)
    {
        $response = LinkDynamicsUser::where('created_by', $id)
            ->orderBy('created_at')
            ->paginate(10);

        return response()->json($response);
    }

    public function create(Request $request) {
        $this->validate($request, [
            'participant' => 'required|string|max:36|min:36',
            'created_by' => 'required|string|max:36|min:36',
            'dynamics' => 'required|string|max:36|min:36'
        ]);
        $response = LinkDynamicsUser::create($request->all());
        return response()->json($response,201);
    }

    public function show($id)
    {
        return response()->json(LinkDynamicsUser::findOrFail($id));
    }
    public function delete($id) {
        try {
            $link_dynamics_user = LinkDynamicsUser::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response('Register not found. '.$e->getMessage(), 404);
        }
        $link_dynamics_user->delete();
        return response()->json(['message' => 'Successfully deleted register', 'register' => $link_dynamics_user]);
    }
}
