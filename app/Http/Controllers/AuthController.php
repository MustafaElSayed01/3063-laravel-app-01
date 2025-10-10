<?php

namespace App\Http\Controllers;

use App\Helpers\AbilityGenerator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\LoggedInMail;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($data);

        $user->role = 'user';
        // $user->is_active = true;
        $user->email_verification_token = Str::uuid();
        $user->save();

        $verificationUrl = url('/api/auth/email/verify?token='.$user->email_verification_token);

        Mail::to($user->email)->send(new VerifyMail($user, $verificationUrl));

        return $this->success([
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'verify_url' => $verificationUrl,
        ], 201);
    }

    /**
     * Web login
     *
     * Validate login credentials and return user with token if valid
     */
    public function web_login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $auth = Auth::attempt($data);
        if ($auth) {
            $user = Auth::user();
            $abilities = AbilityGenerator::generate($user->role, 'web');
            $token = $user->createToken('web', $abilities);
            $user['token'] = $token->plainTextToken;
            // Send email to user
            Mail::to($user['email'])->send(new LoggedInMail($user));

            return $this->success($user);
        }

        return $this->fail(statusCode: 401);
    }

    /**
     * Mobile login
     *
     * Validate login credentials and return user with token if valid
     */
    public function mobile_login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $auth = Auth::attempt($data);
        if ($auth) {
            $user = Auth::user();
            $abilities = AbilityGenerator::generate($user->role, 'mobile');
            $token = $user->createToken('mobile', $abilities);
            $user['token'] = $token->plainTextToken;
            // Send email to user
            Mail::to($user['email'])->send(new LoggedInMail($user));

            return $this->success($user);
        }

        return $this->fail(statusCode: 401);
    }

    /**
     * Verify email address of user
     */
    public function verify_email(Request $request): JsonResponse
    {
        $token = $request->query('token');
        $user = User::where('email_verification_token', $token)->first();
        if (! $user) {
            return $this->fail();
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return $this->success();
    }

    public function resendVerification(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->email_verified_at) {
            return $this->fail();
        }
        $user->email_verification_token = Str::uuid();
        $user->save();
        $verificationUrl = url('/api/auth/email/verify?token='.$user->email_verification_token);
        Mail::to($user->email)->send(new VerifyMail($user, $verificationUrl));

        return $this->success([
            'message' => 'Verification email resent successfully.',
            'verify_url' => $verificationUrl,
        ]);
    }

    // Session Management Routes
    // All Active Sessions for current user
    public function active_sessions(Request $request): JsonResponse
    {
        $user = $request->user();
        $tokens = $user->tokens;

        return response()->json($tokens, 200);
    }

    // Current Session for current user
    public function current_session(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentTokenId = $user->currentAccessToken()->id;
        $currentToken = $user->tokens()->where('id', $currentTokenId)->first();
        if ($currentToken) {
            return response()->json($currentToken, 200);
        }

        return response()->json(['message' => 'No current session found'], 404);
    }

    // Other Sessions for current user
    public function other_sessions(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $otherTokens = $user->tokens()->whereNot('id', $currentTokenId)->get();
        if ($otherTokens->isNotEmpty()) {
            return response()->json($otherTokens, 200);
        }

        return response()->json(['message' => 'No other sessions found'], 404);
    }

    // Show specific session by ID for current user
    public function show_session(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $token = $user->tokens()->where('id', $id)->first();
        if ($token) {
            return response()->json($token, 200);
        }

        return response()->json(['message' => 'Session not found'], 404);
    }

    // Logout from all sessions for current user
    public function logout_all(Request $request): JsonResponse
    {
        $delete = $request->user()->tokens()->delete();

        return $delete ? response()->json(['message' => 'Logged out from all sessions'], 200) : response()->json(['message' => 'Failed to logout'], 500);
    }

    // Logout from current session
    public function logout_current(Request $request): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $delete = $request->user()->tokens()->where('id', $currentTokenId)->delete();

        return $delete ? response()->json(['message' => 'Logged out from current session'], 200) : response()->json(['message' => 'Failed to logout'], 500);
    }

    // Logout from other sessions
    public function logout_others(Request $request): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $delete = $request->user()->tokens()->whereNot('id', $currentTokenId)->delete();

        return $delete ? response()->json(['message' => 'Logged out from other sessions'], 200) : response()->json(['message' => 'Failed to logout'], 500);
    }

    // Logout from specific session by ID
    public function logout_session(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $token = $user->tokens()->where('id', $id)->first();
        if ($token) {
            $token->delete();

            return response()->json(['message' => 'Logged out from the session'], 200);
        }

        return response()->json(['message' => 'Session not found'], 404);
    }

    // Profile

    public function show_profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json($user, 200);
    }
}
