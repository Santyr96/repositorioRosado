<?php

namespace App\Http\Controllers;

use App\Models\Hairdresser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('dashboards.profile', compact('user'));
    }

    public function hairdresser()
    {
        return view('components.forms.insert-hairdresser');
    }


    //Función que se encarga de actualizar el avatar del usuario.
    public function uploadAvatar(Request $request)
    {

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
        $user = auth()->user();

        try {
            //Validamos los datos del formulario.
            $request->validate([
                'name' => 'string',
                'dni' => 'regex:/^\d{8}[A-Za-z]$/',
                'phone' => 'numeric|min:9',

                //Utilizamos el objeto Password el cual nos facilita la validación de las contraseñas.
                'password' => 'confirmed|',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
                'password_confirmation'
            ]);

            //Actualizamos el perfil del usuario.

            //Se ha de comprobar que el campo enviado no este vacío, ya que puede ser que el usaurio haya querido actualizar solo agunos cammpos.
            if ($request->name != '' && $request->name != $user->name) {
                $user->name = $request->name;
            }

            if ($request->dni != '' && $request->dni != $user->dni) {
                $user->dni = $request->dni;
            }

            if ($request->phone != '' && $request->phone != $user->phone) {
                $user->phone = $request->phone;
            }

            if ($request->password != '' && $request->password != $user->password) {
                $user->password = $request->password;
            }

            $user->save();

            //Se devuelve una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Perfil actualizado correctamente'], 200);
        } catch (\Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    //Función que se encarga de añadir una peluquería en nuestra base de datos.
    public function storeHairDresser(Request $request)
    {

        $user = auth()->user();

        try {
            $request->validate([
                'cif' => 'required|regex:/^[ABCDEFGHJKLMNPQRSUVW]\d{8}$/',
                'name' => 'required|string|max:50',
                'address' => ['required', 'string', 'regex:/^(C\/|Calle )?[A-Za-zÀ-ÿ\s]+,\s?\d{1,3},\s?\d{5},\s?[A-Za-zÀ-ÿ\s]+$/'],
                'phone' => 'required|digits:9',
                'latitude' => ['required', 'regex:/^[-+]?((\d|[1-8]\d)(\.\d+)?|90(\.0+)?)$/'],
                'longitude' => ['required', 'regex:/^[-+]?((\d|[1-9]\d|1[0-7]\d)(\.\d+)?|180(\.0+)?)$/']
            ]);


            //Si los datos son correctos, se añade la peluquería a la base de datos.
            //Se crea una nueva instancia del modelo HairDresser para añadir datos a la tabla.
            $hairdresser = new Hairdresser();

            $hairdresser->cif = $request->cif;
            $hairdresser->name = $request->name;
            $hairdresser->address = $request->address;
            $hairdresser->phone = $request->phone;
            $hairdresser->latitude = $request->latitude;
            $hairdresser->longitude = $request->longitude;
            $hairdresser->owner_id = $user->id;

            //Se guardan los cambios en la base de datos.
            $hairdresser->save();

            //Se retorna una respuesta en formato JSON con un mensaje de éxito.
            return response()->json(['success' => 'Peluquería añadida correctamente'], 200);
        } catch (Exception $e) {
            //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
            Log::error('Error al añadir peluquería: ' . $e->getMessage() . '--' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
