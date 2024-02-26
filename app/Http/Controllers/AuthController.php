<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function signIn(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $doctor = DB::table('doctors')
            ->where('email', $email)
            ->first();

        if ($doctor) {
            if (password_verify($password, $doctor->password)) {
                $request->session()->put('doctor', $doctor);

                return redirect()->intended(RouteServiceProvider::HOME);
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function signOut(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->flush();

        return redirect('/');
    }
}
