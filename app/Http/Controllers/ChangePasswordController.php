<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update(['password'=> Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
