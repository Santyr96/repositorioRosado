
@vite('resources/js/auth/validate-reset-password.js')

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
    <div
        class="flex flex-col justify-center items-center bg-white rounded p-6 font-work m-3">
        <h1 class="text-center md:text-xl xl:text-2xl xl:transform xl:-translate-y-5"><strong>Formulario para
                restablecimiento de
                <br>contraseña</strong></h1>
        <br>
        <br>
        <form name="fForm" method="POST" action="{{ route('users.resetPassword') }}" class="h-full flex flex-col w-[80%] gap-1">
            @csrf
            <label for="email">E-mail</label>
            <input class="border-2 border-black px-2" type="email" name="email" id="email"
                placeholder="nombre@gmail.com">

            <x-forms.span-validate class="w-10/12">
            </x-forms.span-validate>

            <label for="password">Contraseña</label>
            <input class="border-2 border-black  px-2" type="password" name="password" id="password" placeholder="Santiago96$">
            <x-forms.span-validate class="max-w-80 ">
            </x-forms.span-validate>

            <label for="password_confirmation">Confirmación de contraseña</label>
            <input class="border-2 border-black px-2" type="password" name="password_confirmation" id="password_confirmation">

            <x-forms.span-validate class="w-10/12">
            </x-forms.span-validate>
            <input type="hidden" name="token" value="{{ $token }}">
            <x-buttons.submit-button id="submit" name="submit" message="Enviar">
            </x-buttons.submit-button>
        </form>

    </div>

</body>

</html>
