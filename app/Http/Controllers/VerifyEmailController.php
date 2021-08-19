<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request): JsonResponse
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return response()->json('Email already verified.');//redirect(env('FRONT_URL') . '/email/verify/already-success');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json('Use your email and password to sign in.');//redirect(env('FRONT_URL') . '/email/verify/success');
    }
}