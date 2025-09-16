<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function web_login(LoginRequest $request)
    {
        $data = $request->validated();
        $auth = Auth::attempt($data);
        if ($auth) {
            $user = Auth::user();
            $token = $user->createToken('web');
            $user['token'] = $token->plainTextToken;
            return $user;
        }
        return 'No';
    }

    public function mobile_login(LoginRequest $request)
    {
        $data = $request->validated();
        $auth = Auth::attempt($data);
        if ($auth) {
            $user = Auth::user();
            $token = $user->createToken('mobile');
            $user['token'] = $token->plainTextToken;
            return $user;
        }
        return 'No';
    }

    public function active_sessions()
    {
        $user = Auth::user();
        return $user->tokens;
    }

    public function logout_session($id)
    {
        $session = Auth::user()->tokens()->where('id', $id)->first();
        $status = $session ? $session->delete() : false;
        return $status ? 'Session deleted Successfully' : 'Session not found';
    }

    public function logout_current()
    {
        $session = Auth::user()->currentAccessToken();
        return $session ? $session->delete() : 'No active session';
    }

    public function logout_others()
    {
        $activeSession = Auth::user()->currentAccessToken();

        $deleted = Auth::user()->tokens()->whereNot('id', $activeSession->id)->delete();

        return $deleted ? 'Logged out from other sessions successfully' : 'No active session';
    }

    public function logout_all()
    {
        $deleted = Auth::user()->tokens()->delete();
        return $deleted ? 'Logged out from all sessions successfully' : 'No active session';
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        return $user;
    }
}
