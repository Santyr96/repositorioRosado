<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Restablecimiento de contraseña</title>
</head>

<body class="flex flex-col justify-center items-center bg-purple-600 h-screen gap-3">
    
 @error('email')
<x-modals.error-modal modalTitle="Error al enviar el link de restablecimiento de contraseña" modalMessage="{{ $errors->first('email') }}"></x-modals.error-modal>
@enderror

@if (session('status'))
<x-modals.error-modal modalTitle="Solicitud de restablecimiento de contraseña" modalMessage="{{ session('status') }}"></x-modals.error-modal>
@endif

    <div
        class="flex flex-col justify-center items-center bg-white rounded p-6 w-72 md:w-2/4 md:h-96 2xl:w-1/3 font-work">
        <h1 class="text-center md:text-xl xl:text-2xl xl:transform xl:-translate-y-5"><strong>Restablecimiento de
                <br>Contraseña</strong></h1>
        <br>
        <p class="xl:text-xl text-center">¿Has olvidado tu contraseña? Por favor, introduce tu e-mail para restablecer tu
            contraseña.
        </p>
        <br>
        <form method="POST" action="{{ route('users.sendResetLink') }}">
            @csrf
            <input class="border-2 border-black mb-4 px-2" type="email" name="email" id="email"
                placeholder="nombre@gmail.com">
            <x-buttons.submit-button id="submit" name="submit" message="Enviar">

            </x-buttons.submit-button>
        </form>

    </div>

    <a class="text-white hover:text-gray-400 font-work  px-4" href="{{route('users.login')}}">Volver a inicio de sesión</a>

</body>

</html>
