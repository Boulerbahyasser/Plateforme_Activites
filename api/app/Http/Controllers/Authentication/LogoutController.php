<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        $user = Auth::user();
        // suprimer la token qui genirer au niveaux authentification
        $user->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message' => 'you are successfully logout '
        ]);
    }
}
