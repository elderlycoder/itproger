<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function login(Request $req){
        $this->validate($req, [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(Auth::attempt(['email'=>$req->get('email'), 'password'=>$req->get('password')])){
            return redirect('/');
        }
        return redirect()->back()-with(['status='=>'ok']);
        //return Redirect::back()->withErrors(['msg', 'The Message']);
         
    }

}
