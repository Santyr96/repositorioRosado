<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function login(){
        return view('users.loginView');  //Retorna la vista login.
    }

    public function create(){
        return view('users.create');  //Retorna la vista register.
    }

    //Función para el registro de un nuevo usuario.
    public function store (Request $request){

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
        return to_route('users.create');

    }
}
