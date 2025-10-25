<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class SessionController extends Controller
{
    public function create(){
        return view("auth.login");
    }

    public function store(){
        //validate
        $validated = request()->validate([
            'email' => ['required','email'],
            'password'=> ['required'],
        ]);
        //attempt to log him in
        if(!Auth::attempt($validated)) {
            throw ValidationValidationException::withMessages(['email'=> 'credintials not match!']);
        }
        //regenerate sessio token
        request()->session()->regenerate();
        //redirect
        return redirect('/');
    }

    public function destroy(){
        Auth::logout();
        return redirect('/');
    }
}
