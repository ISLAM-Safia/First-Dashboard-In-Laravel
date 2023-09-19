<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Dotenv\Validator;
// use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function showLogin()
    {
        return response()->view('cms.auth.login');
    }
    public function login(Request $request)
    {
        // dd($request->all());
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
            'remember' => 'required|boolean'
        ]);
        if (!$validator->fails()) {
            // $credentials = [
            //     'email' => $request->input('email'),
            //     'password' => $request->input('password'),
            // ];
            if (Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->input('remember'))) {
                return response()->json(['message' => 'Login Successfully '], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Credentials Error '], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}
