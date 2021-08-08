<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm(){
        return view('pages.register');
    }

    public function register(Request $req){
        $this->validate($req, [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        
        $user = User::add($req->all()); //создаём нового пользователя вызывая метод add модели User
        $user->generatePassword($req->get('password'));

        return redirect('/login');
    }

    public function loginForm(){
        return view('pages.login');
    }

}
