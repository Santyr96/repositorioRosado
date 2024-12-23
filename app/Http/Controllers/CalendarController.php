<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hairdresser;
use App\Models\Signup;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

//Clase que se encarga de controlar las vistas de calendario.
class CalendarController extends Controller
{
    //Funcion que se encarga de encontrar las peluquerias donde el cliente se ha dado de alta.
    public function findSignup()
    {
        //Si el usuario no esta autenticado se redirige a la pagina de login.
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        //Si el usuario tiene el rol de cliente, seleccionamos las peluquerias a las que se ha dado de alta.
        if (auth()->user()->role == 'cliente') {
            $signups = Signup::where('client_id', auth()->user()->id)->get();
            $hairdressers = [];
            foreach ($signups as $signup) {
                $hairdresser = Hairdresser::where('id', $signup->hairdresser_id)->first();
                $hairdressers[] = $hairdresser;
            }
            return view('dashboards.select-signup', compact('hairdressers'));
            
            //Si el usuario tiene el rol de propietario seleccionamos todas sus peluquerias.
        } else if (auth()->user()->role == 'propietario') {
            $hairdressers = Hairdresser::where('owner_id', auth()->user()->id)
            ->get();
            Log::info('Hairdressers: ' . $hairdressers);
            return view('dashboards.select-signup', compact('hairdressers'));
        } 

    }

    //Funcion que se encarga de mostrar el calendario de la peluquería seleccionada.
    public function showCalendar(Request $request)
    {
       try{

        //Se valida que se haya enviado el id de la peluquería.
        $request->validate([
            'hairdresser_id' => 'required|exists:hairdressers,id', 
        ]);
    
        //Buscamos la peluqueria en la Base de Datos.
        $hairdresser = Hairdresser::find($request->hairdresser_id);

        //Se obtienen los servicios de la peluquería.
        $services = Service::where('hairdresser_id', $request->hairdresser_id)->get();

        //Se obtienen los clientes de la peluquería.
        $clients = $hairdresser->clients()->get();
    
        //Se devuelve la vista con los datos de los servicios la peluquería y los clientes asociados a esta.
        return view('dashboards.calendar', compact('services', 'hairdresser', 'clients'));

        }catch(\Exception $e){
            Log::error('Error al mostrar el calendario: ' . $e->getMessage());
            return response()->json(['error' => 'Error al mostrar el calendario'], 500);
        }
    }
    


}
