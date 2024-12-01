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
    <title>Aviso de verificación de E-mail</title>
</head>

<body class="flex justify-center items-center bg-purple-600 h-screen">
    
    <div class="flex flex-col justify-center items-center bg-white rounded p-6 w-72 md:w-2/4 md:h-96 2xl:w-1/3 font-work">
        <h1 class="text-center md:text-xl xl:text-2xl xl:transform xl:-translate-y-5"><strong>Aviso de verificación de <br>E-mail</strong></h1>
        <br>
        <p class="xl:text-xl text-center">Gracias por registrarte. Antes de empezar, ¿Podrías verificar dirección de 
            e-mail haciendo click al enlace que acabamos de enviar? Si no has recibido
            el e-mail, te proporcionaremos otro. Muchas gracias.
        </p>
        <br>
        <form method="POST" action="{{route('verification.send')}}">
            @csrf
            <x-buttons.submit-button id="submit" name="submit" message="Reenviar enlace">
               
            </x-buttons.submit-button>
        </form>
    </div>

</body>
</html>