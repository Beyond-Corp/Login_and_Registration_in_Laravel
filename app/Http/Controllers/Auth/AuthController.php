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

        // Ici on crée un nouvel utilisateur dans la base de données; et on lui attribue les valeurs entrées par l'utilisateur dans le formulaire d'inscription
        $User = new User(); // on crée un nouvel utilisateur
        $User->name = $request->name; // on attribue le nom de l'utilisateur à la variable name
        $User->email = $request->email; // on attribue l'email de l'utilisateur à la variable email
        $User->password = bcrypt($request->password); // on attribue le mot de passe de l'utilisateur à la variable password
        //ici on sauvegarde les données de l'utilisateur dans la base de données
        if ($User->save()){ // si l'inscription est réussie on redirige l'utilisateur vers la page de connexion avec un message de succès 
            return redirect()->route('login')->with('success','Inscription réussie'); // on redirige l'utilisateur vers la page de connexion avec un message de succès
        }
        return back()->with('error','Erreur lors de l\'inscription'); // si l'inscription échoue on redirige l'utilisateur vers la page d'inscription avec un message d'erreur


    }



    public function postLogin(Request $request){
        $this->validate($request,[//cette fonction permet de valider les données entrées par l'utilisateur lors de la connexion
            'email'=>'required|email',
            'password'=>'required|min:6',//dddmhsdjkhuekjsq i like hjhakhsbkbnkjqnbckubcxujcn w b 
        ]);

        $UserCrendentials=$request->only("email","password"); // on récupère les données entrées par l'utilisateur dans le formulaire de connexion grace a la fonction "only" et on les stocke dans la variable $UserCrendentials

        if(Auth::attempt($UserCrendentials)){ // ici on vérifie si les données entrées par l'utilisateur correspondent à celles de la base de données
            return redirect()->intended(route('home')); // Si les données sont correctes, on redirige l'utilisateur vers la page d'accueil. "intended" permet de rediriger l'utilisateur vers la page qu'il voulait visiter avant d'être redirigé vers la page de connexion. Oui, la méthode redirect()->intended(route('home')) effectue effectivement deux actions à la fois dans le contexte de la gestion des sessions utilisateur et des redirections : elle redirige l'utilisateur vers la page qu'il voulait visiter avant d'être redirigé vers la page de connexion, et elle redirige l'utilisateur vers la page d'accueil si la page qu'il voulait visiter avant d'être redirigé vers la page de connexion n'est pas définie.

        }
        return redirect (route('login'))->with('error','Email ou mot de passe incorrect'); // si les données sont incorrectes on redirige l'utilisateur vers la page de connexion avec un message d'erreur
       }



}
