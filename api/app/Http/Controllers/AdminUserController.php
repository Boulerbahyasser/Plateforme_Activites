<?php

namespace App\Http\Controllers;

use App\Models\Animateur;
use App\Models\Father;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function deleteParent(Father $parent){
        $user = User::find($parent->user_id);
        $user->delete();
        return response()->json(['message'=>'the delete was successful'],200);
    }
    public function deleteAnimateur(Animateur $animateur){
        $user = User::find($animateur->user_id);
        $user->delete();
        return response()->json(['message'=>'the delete was successful'],200);
    }
}
