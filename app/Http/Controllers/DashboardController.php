<?php

namespace App\Http\Controllers;

use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\Signup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

//Clase que se encarga de controlar las vistas del dashboard.
class DashboardController extends Controller
{
    //Función que se encarga de mostrar la vista de actualización del perfil del usuario.
    public function profile()
    {
        $user = auth()->user();
        return view('dashboards.profile', compact('user'));
    }

    //Función que se encarga de mostrar la vista para el registro de una peluquería.
    public function hairdresser()
    {
        return view('dashboards.insert-hairdresser');
    }

    //Función que se encarga de mostrar la vista para la gestión de los servicios de la peluquería.
    public function showServices(Request $request)
    {
        try {
            //Se obtiene el usuario autenticado.
            $user = auth()->user();

            //Se verifica si el usuario esta autenticado y se registra en los logs de laravel.
            if (!$user) {
                Log::error("No se pudo obtener el usuario autenticado.");
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            //Se realiza una consulta a la base de datos para obtener la peluquería del usuario.
            $hairdresser = Hairdresser::where('id', $request->hairdresser_id)
                ->select('id', 'name')
                ->first();

            //Si no se encuentra la peluquería se registra en los logs.
            if (!$hairdresser) {
                Log::error("No se encontró la peluquería para el usuario con id: {$user->id}");
                return response()->json(['error' => 'Peluquería no encontrada'], 404);
            }

            //Se realiza una consulta a la base de datos para obtener los servicios asociados a la peluquería.
            $services = Service::where('hairdresser_id', $hairdresser->id)
                ->orderBy('id')
                ->get();

            return view('dashboards.services_view', compact('hairdresser', 'services'));
        } catch (\Exception $e) {

            Log::error('Error en showServices: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
            ]);

            return response()->json(['error' => 'Ocurrió un error en el servidor'], 500);
        }
    }

    //Función que se encarga de mostrar la vista para la selección de la peluquería.
    public function selectHairdresser()
    {
        //Si el usuario no esta autenticado se redirige a la pagina de login.
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role == 'propietario') {
            $hairdressers = Hairdresser::where('owner_id', auth()->user()->id)
                ->get();
            Log::info('Hairdressers: ' . $hairdressers);
            return view('dashboards.select-hairdresser', compact('hairdressers'));
        }
    }

    //Función que se encarga de mostrar la vista de peluquerías para que los clientes se den de alta.
    public function showHairdressers()
    {
        //Se obtiene el usuario autenticado.
        $user = auth()->user();

        //Se obtiene todo el listado de las peluquerías registradas en nuestra base de datos.
        $hairdressers = Hairdresser::all();

        //Se obtiene la lista de las peluquerías en las que el cliente se ha dado de alta.
        $signups = Signup::where('client_id', $user->id)
            ->pluck('hairdresser_id');

        //Se obtiene las peluquerías correspondientes a los IDs de $signups.
        $hairdressersSignedUp = Hairdresser::whereIn('id', $signups)
            ->select('id', 'name')
            ->get();

        //Se retorna la vista con los datos obtenidos.
        return view('dashboards.user-signup-hairdresser', compact('hairdressers', 'hairdressersSignedUp'));
    }



    //Función que se encarga de actualizar el avatar del usuario.
    public function uploadAvatar(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        //Verificamos si el usuario tiene un avatar.
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            //Se añade un nombre a la imagen cargada por el usuario.
            $imageName = $user->name . '_' . $image->getClientOriginalName();

            //Si el usuario ya tiene una imagen en nuestro servidor, eliminamos la que tenia y la actualizamos con la que se ha cargado.
            if ($user->avatar) {
                $oldImage = public_path($user->avatar);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            //Se ubica la nueva imagen cargada por el usuario en el directorio deseado.
            $image->move(public_path('storage/uploads'), $imageName);
            $path = 'storage/uploads/' . $imageName;
            $user->avatar = $path;
            $user->save();

            //Se devuelve una respuesta en formato JSON con la URL de la imagen cargada.
            return response()->json(['avatar_url' => asset($path)], 200);
        }
        //Si no se ha enviado ningun archivo, se devuelve una respuesta en formato JSON.
        return response()->json(['error' => 'No se ha enviado ninguna imagen'], 400);
    }

    //Función que se encarga de actualizar el perfil del usuario.
public function updateProfile(Request $request)
{
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $changesMade = false;

    if (!$user) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    try {
        $request->validate([
            'name' => 'nullable|string',
            'dni' => 'nullable|regex:/^\d{8}[A-Za-z]$/',
            'phone' => 'nullable|numeric|digits:9',
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($request->filled('name') && $request->name !== $user->name) {
            $user->name = $request->name;
            $changesMade = true;
        }

        if ($request->filled('dni') && $request->dni !== $user->dni) {
            Log::info("Hola");
            $user->dni = $request->dni;
            $changesMade = true;
        }

        if ($request->filled('phone') && $request->phone !== $user->phone) {
            $user->phone = $request->phone;
            $changesMade = true;
        }

        if ($request->filled('password')) {
            if (!password_verify($request->password, $user->password)) {
                $user->password = bcrypt($request->password);
                $changesMade = true;
            }
        }

        
        if (!$changesMade) {
            return response()->json(['error' => 'No se realizaron cambios en el perfil'], 400);
        }  

        $user->save();

       
        return response()->json(['success' => 'Perfil actualizado correctamente'], 200);
    } catch (ValidationException $e) {
        
        return response()->json(['error' => $e->validator->errors()->first()], 400);
    } catch (\Exception $e) {
        Log::error('Error al actualizar: ' . $e->getMessage() . '--' . $e->getTraceAsString());
        return response()->json(['error' => 'Ocurrió un error inesperado.'], 500);
    }
}


    //Función que se encarga de añadir una peluquería en nuestra base de datos.
    public function storeHairDresser(Request $request)
    {

        $user = auth()->user();

        if ($user->role != 'propietario') {
            return response()->json(['error' => 'No tienes permisos para realizar esta acción'], 403);
        }

        try {
            $request->validate([
                'cif' => 'required|regex:/^[ABCDEFGHJKLMNPQRSUVW]\d{8}$/',
                'name' => 'required|string|max:50',
                'address' => ['required', 'string', 'regex:/^(C\/|Calle )?[A-Za-zÀ-ÿ\s]+,\s?\d{1,3},\s?\d{5},\s?[A-Za-zÀ-ÿ\s]+$/'],
                'phone' => 'required|digits:9',
            ]);

            if (Hairdresser::where('cif', $request->cif)->exists()) {
                return response()->json(['error' => 'Ya existe una peluquería registrada con este CIF'], 400);
            }

            //Si los datos son correctos, se añade la peluquería a la base de datos.
            //Se crea una nueva instancia del modelo HairDresser para añadir datos a la tabla.
            $hairdresser = new Hairdresser();

            $hairdresser->cif = $request->cif;
            $hairdresser->name = $request->name;
            $hairdresser->address = $request->address;
            $hairdresser->phone = $request->phone;
            $hairdresser->owner_id = $user->id;

            //Se guardan los cambios en la base de datos.
            $hairdresser->save();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Peluquería añadida correctamente'], 200);
        } catch (ValidationException $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            Log::error('Error al añadir peluquería: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Función para eliminar una peluquería.
    public function deleteHairdresser(Request $request){
        try{
            if (empty($request->hairdresser_id)) {
                return response()->json(['error' => 'No has seleccionado ninguna peluquería'], 400); 
            }
            

            $hairdresser = Hairdresser::find($request->hairdresser_id);

            if(!$hairdresser){
                return response()->json(['error' => 'Peluquería no encontrada'], 404);
            }

            //Se elimina el servicio.
            $hairdresser->delete();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Peluquería eliminada correctamente'], 200);

        }catch(Exception $e){
            Log::error('Error al eliminar la peluquería -> ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Función que se va a encargar de crear servicios.
    public function createService(Request $request)
    {
        try {

            $user = auth()->user();
            if ($user->role != 'propietario') {
                return response()->json(['error' => 'No tienes permisos para realizar esta acción'], 403);
            }

            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|decimal:2|min:0',
                'description' => 'nullable|string|max:255',
            ]);

            //Se crea una nueva instancia del modelo Service para añadir datos a la tabla.
            $service = new Service();

            $service->name = $request->name;
            $service->price = $request->price;
            $service->description = $request->description;
            $service->hairdresser_id = $request->idHairdresser;

            //Se guardan los cambios en la base de datos.
            $service->save();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Servicio añadido correctamente'], 200);
        } catch (ValidationException $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            Log::error('Error al añadir servicio: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Función que se va a encargar de actualizar un servicio.
    public function updateService(Request $request, $serviceId)
    {
        try {

            $user = auth()->user();

            if ($user->role != 'propietario') {
                return response()->json(['error' => 'No tienes permisos para realizar esta acción'], 403);
            }

            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|decimal:2|min:0',
                'description' => 'nullable|string|max:255',
            ]);

            //Se obtiene el servicio a actualizar.
            $service = Service::find($serviceId);

            if (!$service) {
                return response()->json(['error' => 'Servicio no encontrado'], 404);
            }

            //Se actualizan los datos del servicio.
            if ($request->name != '' && $request->name != $service->name) {
                $service->name = $request->name;
            }

            if ($request->price != '' && $request->price != $service->price) {
                $service->price = $request->price;
            }

            if ($request->description != '' && $request->description != $service->description) {
                $service->description = $request->description;
            }

            //Se guardan los cambios en la base de datos.
            $service->save();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Servicio actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            Log::error('Error al actualizar servicio: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            Log::error('Error al actualizar servicio: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Función que se va a encargar de eliminar un servicio.
    public function deleteService($serviceId)
    {
        try {
            $user = auth()->user();
            if ($user->role != 'propietario') {
                return response()->json(['error' => 'No tienes permisos para realizar esta acción'], 403);
            }

            //Se obtiene el servicio a eliminar.
            $service = Service::find($serviceId);

            if (!$service) {
                return response()->json(['error' => 'Servicio no encontrado'], 404);
            }

            //Se elimina el servicio.
            $service->delete();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Servicio eliminado correctamente'], 200);
        } catch (Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            Log::error('Error al eliminar servicio: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Función que se encarga de registar una nueva alta en una peluqueria.
    public function signupHairdresser(Request $request)
    {
        auth()->user();
        if (auth()->user()->role != 'cliente') {
            return response()->json(['error' => 'No tienes permisos para realizar esta acción'], 403);
        }

        try {

            //Si el request viene vacio, se retorna un error.
            if ($request->hairdresser_id == '' || $request->hairdresser_id == null) {
                return response()->json(['error' => 'No se ha seleccionado ninguna peluquería'], 400);
            };

            $request->validate([
                'hairdresser_id' => 'required|integer',
            ]);

            //Seleccionamos la peluqueria con la id del cliente, y que coincida con el id enviado en el request.
            $signupSelect = Signup::where('client_id', auth()->user()->id)
                ->where('hairdresser_id', $request->hairdresser_id)
                ->first();

            $hairdresser = Hairdresser::find($request->hairdresser_id);
            if (!$hairdresser) {
                return response()->json(['error' => 'Peluquería no encontrada'], 404);
            }

            if ($signupSelect != null) {
                if ($request->hairdresser_id == $signupSelect->hairdresser_id) {
                    return response()->json(['error' => 'Ya te has dado de alta en la peluquería'], 400);
                };
            }

            //Se crea una nueva instancia del modelo Signup para añadir datos a la tabla.
            $signup = new Signup();
            //Se asignan los nuevos datos a la base de datos Signup.
            $signup->client_id = auth()->user()->id;
            $signup->hairdresser_id = $request->hairdresser_id;

            //Se guardan los cambios en la base de datos.
            $signup->save();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Se ha dado de alta correctamente'], 200);
        } catch (ValidationException $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            Log::error('Error al realizar alta: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            //Se retorna una respuesta en formato JSON con un mensaje de error.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
