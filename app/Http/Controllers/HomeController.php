<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    //Creamos método para mostrar la vista index.

    public function index(){
        return view('index');  //Retorna la vista index.
    }

    public function about(){
        return view('about');  //Retorna la vista about.
    }

    public function aboutSantiago(){
        return view('aboutSantiago');  //Retorna la vista aboutSantiago.
    }

    public function dashboard(){
        return view('dashboards.customer');  //Retorna la vista dashboard.
    }

   
}
