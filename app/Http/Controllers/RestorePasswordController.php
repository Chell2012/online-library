<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordSecondRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RestorePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendToken(ResetPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return response()->json(
            $status === Password::RESET_LINK_SENT
                ? ['message' => 'Successfully. Please check your email']
                : ['message' => 'Something wrong. Check your email address or try again latter'], 200
        );
    }
    public function changePassword(ResetPasswordSecondRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        return response()->json(
            $status === Password::PASSWORD_RESET
                ? ['message' => 'Successfully. Login with your email and password']
                : ['message' => 'Something wrong'], 200
        );
    }
}
