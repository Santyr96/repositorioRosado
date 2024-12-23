<?php

namespace App\Http\Controllers;


//Clase que se encarga de controlar las vistas de inicio de la aplicación.
class HomeController extends Controller
{
    
    //Funcion para cargar la vista index.
    public function index(){
        return view('index');  
    }

    //Función que carga la vista about-me.
    public function aboutMe(){
        return view('about-me');  
    }


}
