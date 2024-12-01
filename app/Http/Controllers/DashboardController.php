<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function profile()
    {
        //Se obtiene el usuario autenticado.
        $user = auth()->user(); 
    
        if (!$user) {
            abort(403, 'No autorizado');
        }

        Log::info('Usuario autenticado:', ['id' => $user->id, 'email' => $user->email]);
    
        $title = 'Perfil'; 
        
        return view('dashboards.profile', compact('user', 'title')); 
    }


    //Función que se encarga de actualizar el avatar del usuario.
    public function uploadAvatar(Request $request){
       
        $user = auth()->user();

        //Verificamos si el usuario tiene un avatar.
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            //Se añade un nombre a la imagen cargada por el usuario.
            $imageName = $user->name.'_'.$image->getClientOriginalName();

            //Si el usuario ya tiene una imagen en nuestro servidor, eliminamos la que tenia y la actualizamos con la que se ha cargado.
            if($user->avatar){
                $oldImage = public_path($user->avatar);
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }

            //Se ubica la nueva imagen cargada por el usuario en el directorio deseado.
            $image->move(public_path('storage/uploads'), $imageName);
            $path = 'storage/uploads/'.$imageName;
            $user->avatar = $path;
            $user->save();

            //Se devuelve una respuesta en formato JSON con la URL de la imagen cargada.
            return response()->json(['avatar_url' => asset($path)], 200);
        }
        //Si no se ha enviado ningun archivo, se devuelve una respuesta en formato JSON.
        return response()->json(['error' => 'No se ha enviado ninguna imagen'], 400);
    }

    //Función que se encarga de actualizar el perfil del usuario.
    public function updateProfile(Request $request){
        $user = auth()->user();

        try{
        //Validamos los datos del formulario.
        $request->validate([
            'name' => 'string',
            'dni' => 'regex:/^\d{8}[A-Za-z]$/',
            'phone' => 'numeric|min:9',
            
            //Utilizamos el objeto Password el cual nos facilita la validación de las contraseñas.
            'password' => 'confirmed|', Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
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

        if($request->phone != '' && $request->phone != $user->phone){
            $user->phone = $request->phone;
        }
        
        if ($request->password != '' && $request->password != $user->password) {
            $user->password = $request->password;
        }
        
        $user->save();

        //Se devuelve una respuesta en formato JSON con un mensaje de éxito.
        return response()->json(['success' => 'Perfil actualizado correctamente'], 200);

    }catch(\Exception $e){
        //Si ocurre un error, se devuelve una respuesta en formato JSON con el mensaje de error.
        return response()->json(['error' => $e->getMessage()], 400);
    }

    
}

}
