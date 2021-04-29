<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

/**
 * Description of UserController
 *
 * @author vyacheslav
 */
class UserController extends BaseController {
    
    public function login(Request $request)
    {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Authentication passed...
                 $user = Auth::user();
                 $token = $user->createToken('Token Name')->accessToken;

                return response()->json($token);
            }
    }
    //put your code here
}
