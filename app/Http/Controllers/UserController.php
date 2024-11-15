<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(){
        return view('users.loginView');  //Retorna la vista login.
    }

    public function create(){
        return view('users.create');  //Retorna la vista register.
    }

    public function dashboard(){
        return view('dashboards.dashboard');  //Retorna la vista dashboard.
    }

    //Función que se encargará de autenticar al usuario, tanto si es cliente como propietario.
    public function loginEntrance(Request $request)
{
    try {
        // Validar las credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        /**
         * Para recordar la sesión del usuario se crea una variable remember que recibira el estado del 
         * check del formulario. Si este es marcado por el usuario, se recordara su sesión hasta que
         * cierre sesión o se acabe el tiempo de activicación de la cookie.
         */
        $remember = $request->has('remember');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return to_route('users.dashboard');
        } else {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ])->onlyInput('email');
        }
    } catch (\Exception $e) {
        return back()->withErrors(['general' => 'Hubo un problema al iniciar sesión el usuario. Inténtelo de nuevo.']);
    }
}


    //Función para el registro de un nuevo usuario.
    public function store (Request $request){

        try{

        
        //Validamos los datos.
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'numeric|min:9',
            'dni' => 'required|regex:/^\d{8}[A-Za-z]$/',
            'sex' => 'required|in:masculino,femenino',
            'rol' => 'required|in:cliente,propietario',

            //Utilizamos el objeto Password el cual nos facilita la validación de las contraseñas.
            'password' => 'required|confirmed|', Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
            'password_confirmation' => 'required',
        ]);

        //Si los datos son correctos, creamos un nuevo usuario en la base de datos.
      

        //Creamos un nuevo objeto de la clase Model User.
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dni = $request->dni;
        $user->sex = $request->sex;
        $user->role = $request->rol;
        $user->password = $request->password;

        //Guardamos los cambios en la base de datos.
        $user->save();

        //Redirigimos a la vista de registro [MODIFICACION].
        return to_route('users.dashboard');

    }catch(\Exception $e){
        return back()->withErrors(['general' => 'Hubo un problema al guardar el usuario. Inténtelo de nuevo.']);
}
    }


    //Función para cerrar sesión.
    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('users.login');
}
}