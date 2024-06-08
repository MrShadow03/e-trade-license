<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;

class UserController extends Controller{
    public function show($nid) {
        $user = User::where('national_id_no', $nid)->first();
        if($user){
            return new UserResource($user);
        }else{
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
