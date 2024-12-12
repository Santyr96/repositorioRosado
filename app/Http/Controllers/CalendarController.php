<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hairdresser;
use App\Models\Signup;
use App\Models\Appointment;
use App\Models\Service;

class CalendarController extends Controller
{
    //Funcion que se encarga de encontrar las peluquerias donde el cliente se ha dado de alta.
    public function findSignup()
    {
        //Seleccionamos las peluquerias donde el cliente se ha dado de alta.
        $signups = Signup::where('client_id', auth()->user()->id)->get();
        $hairdressers = [];
        foreach ($signups as $signup) {
            //Seleccionamos los datos de la peluqueria.
            $hairdresser = Hairdresser::where('id', $signup->hairdresser_id)->first();
            //Añadimos los datos de la peluqueria al array.
            $hairdressers[] = $hairdresser;
        }

        //Se retorna la vista con los datos de las peluquerias.
        return view('dashboards.select-signup', compact('hairdressers'));
    }

    public function showCalendar(Request $request)
    {
       
        // Validar que se haya enviado un ID de peluquería
        $request->validate([
            'hairdresser_id' => 'required|exists:hairdressers,id', // Asegura que el ID es válido
        ]);
    
        // Obtener los servicios de la peluquería.
        $services = Service::where('hairdresser_id', $request->hairdresser_id)->get();
    
        // Retornar la vista con los servicios obtenidos
        return view('dashboards.calendar', compact('services'));
    }
    


}
