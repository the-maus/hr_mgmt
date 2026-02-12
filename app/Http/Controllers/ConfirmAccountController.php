<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token)
    {
        // validate token
        $user = User::where('confirmation_token', $token)->first();

        if (!$user)
            abort(403, 'Invalida confirmation token');

        return view('auth.confirm-account', compact('user'));
    }

    public function confirmAccountSubmit(Request $request)
    {
        $request->validate([
            'token'    => 'required|string|size:64',
            'password' => 'required|confirmed|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // confirmed considers "{$field_name}_confirmation"
        ]);

        $user = User::where('confirmation_token', $request->token)->first();
        $user->password = bcrypt($request->password);
        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login');
    }
}
