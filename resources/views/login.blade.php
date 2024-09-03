<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Custom CSS --}}
    <style>
        @media (min-width: 576px){
            .w-sm-50 {
                width:50% !important;
            }
        }

        @media (min-width: 992px){
            .w-lg-25 {
                width:25% !important;
            }
        }
    </style>

</head>
<body class="d-flex justify-content-center align-items-center w-100 vh-100 bg-light-subtle">
    <main class="w-100 w-sm-50 w-lg-25 mx-5 m-auto border-black">
        <form class="">
                <div class="mt-3 pb-2" style="width: 70px;">
                    <img src="{{asset('img/logo.png')}}" class="logo img-fluid" >
                </div>
            <h1 class="h3 mb-3 fw-normal">Sign in</h1>
            <div class="form-floating">
                <input type="username" class="form-control rounded-0 rounded-top-2" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating pb-4">
                <input type="password" class="form-control rounded-0 rounded-bottom-2" id="floatingpassword" placeholder="password">
                <label for="floatingpassword">Password</label>
            </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
        <p class="mt-5 mb-3 text-body-secondary text-center">Copyright &copy; Pusat Survei Geologi, 2024</p>
</form>
</main>
</body>
</html>