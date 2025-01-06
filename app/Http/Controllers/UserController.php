<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Validation\ValidationException;

//Clase que se encarga de controlar las vistas que tienen que ver con los usuarios.
class UserController extends Controller
{

    //Importamos el servicio de notificaciones.
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    //Función que se encargará de mostrar el formulario de inicio de sesión.
    public function login(){
        return view('users.login-view');  
    }

    //Función que se encargará de mostrar el formulario de registro.
    public function create(){
        return view('users.create');  
    }

    //Función que se encargará de mostrar el dashboard del usuario.
    public function dashboard(){
        $user = User::find(Auth::user()->id);
        $notifications = $this->notificationService->getUnreadNotifications($user);
        return view('dashboards.dashboard', ['userName' => Auth::user()->name], compact('notifications'));
    }

    //Función que se encargará de marcar todas las notificaciones como leídas.
    public function markAllAsRead(){
        $user = User::find(Auth::user()->id);
        $this->notificationService->markAllAsRead($user);
    }
    //Función que se encargará de mostrar el formulario de restablecimiento de contraseña.
    public function forgotPassword(){
        return view('auth.forgot-password');  
    }

    //Función que se encargará de enviar el link de restablecimiento de contraseña. 
    public function sendResetPasswordLink(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = FacadesPassword::sendResetLink(
            $request->only('email')
        );

        return $status === FacadesPassword::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    //Función que se encargará de mostrar el formulario de restablecimiento de la contraseña.
    public function resetPasswordForm($token){
        return view('auth.reset-password', ['token' => $token]);
    }

    //Función que se encargará de actualizar la contraseña del usuario en la base de datos.
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = FacadesPassword::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));

                
                
            }
        );

        return $status === FacadesPassword::PASSWORD_RESET
                ? redirect()->route('users.login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
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

        Log::info('Intento de inicio de sesión para el usuario: ' . $credentials['email']);

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
                'general' => 'Las credenciales proporcionadas son incorrectas.',
            ])->onlyInput('email');
        }
    } catch (\Exception $e) {
        Log::error('Error al iniciar sesión: ' . $e->getMessage());
        return back()->withErrors([
            'general' => 'Hubo un problema al iniciar sesión. Inténtelo de nuevo. '
        ]);
    }
}


    //Función para el registro de un nuevo usuario.
    public function store(Request $request)
    {
        try {
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'required|digits:9',
                'dni' => 'required|regex:/^\d{8}[A-Za-z]$/|unique:users',
                'sex' => 'required|in:masculino,femenino',
                'rol' => 'required|in:cliente,propietario',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
            ]);
    
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->dni = $request->dni;
            $user->sex = $request->sex;
            $user->role = $request->rol;
            $user->password = bcrypt($request->password); 
    
            
            $user->save();
    
            
            event(new Registered($user));
            Auth::login($user);
    
            return redirect()->route('users.dashboard');
    
        }catch (ValidationException $e){
            Log::error('Error al registrar el usuario: ' . $e->getMessage());
            Log::error('Detalles del error: ' . $e->getTraceAsString());
            return back()->withErrors([
                'general' => 'Hubo un problema al registrar el usuario. '.$e->getMessage()
            ])->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error al registrar el usuario: ' . $e->getMessage());
            Log::error('Detalles del error: ' . $e->getTraceAsString());
            return back()->withErrors([
                'general' => 'Hubo un problema al registrar el usuario. Por favor, inténtelo de nuevo.'
            ])->withInput();
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