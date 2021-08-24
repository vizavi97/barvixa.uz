<?php

namespace Tim\Vavilon\Classes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RainLab\User\Models\User;
use Tim\Vavilon\Models\Refs;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;

class VavilonController extends Controller
{
    public function getContacts(Request $request) {
        $token = $request->header('Authorization');
        $user = JWT::toUser($token);
        $contacts_ids = Refs::where('user_id', $user->id)->pluck('ref_id')->toArray();
        $refs = User::find($contacts_ids)->map->only('id', 'name','surname');
        return response()->json($refs);
    }
}