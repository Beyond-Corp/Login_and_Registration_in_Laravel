<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }



    public function Registration(){
        return view('auth.registration');
    }


    public function postRegistration(Request $request){
        $this->validate($request,[//cette fonction permet de valider les données entrées par l'utilisateur lors de l'inscription
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ]);

        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = bcrypt($request->password);
        if ($User->save()){
            return redirect()->route('login')->with('success','Inscription réussie');
        }
        return back()->with('error','Erreur lors de l\'inscription');


    }

    public function postLogin(Request $request){
        $this->validate($request,[//cette fonction permet de valider les données entrées par l'utilisateur lors de la connexion
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);

        $UserCrendentials=$request->only("email","password");

        if(Auth::attempt($UserCrendentials)){ 
            return redirect()-> intended (route('home'));
        }
        return redirect (route('login'))->with('error','Email ou mot de passe incorrect');
       }



}
