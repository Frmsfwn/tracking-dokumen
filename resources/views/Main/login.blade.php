<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Google  reCAPTCHA --}}
    <script async src="https://www.google.com/recaptcha/api.js"></script>

    {{-- Custom CSS --}}
    <style>
        .end-reveal {
            right: 1rem;
        }

        .top-reveal {
            top: 1.9rem;
        }

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
        <form class="" action="" method="POST">
            @csrf
                <div class="mt-3 pb-2" style="width: 70px;">
                    <img src="{{asset('img/logo.png')}}" class="logo img-fluid" >
                </div>
            <h1 class="h3 mb-3 fw-normal">Sign in</h1>
            <div class="form-floating">
                <input type="username" id="floatingInput" placeholder="" name="username" @if($errors->hasBag('login')) value="{{ old('username') }}" @endif maxlength="15" autocomplete="off" autocapitalize="off" class="form-control rounded-0 rounded-top-2 @if($errors->login->has('username')) border-danger @else border-primary @endif @error('username', 'login') is-invalid @enderror" @required(true)>
                <label for="floatingInput">Username</label>
                @error('username', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('username') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" id="floatingpassword" placeholder="" name="password" maxlength="50" autocomplete="off" autocapitalize="off" class="form-control rounded-0 rounded-bottom-2 @if($errors->login->has('password')) border-danger @else border-primary @endif  @error('password', 'login') is-invalid @enderror" @required(true)>
                <label for="floatingpassword">Password</label>
                <span class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg"></i>
                </span>
                @error('password', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('password') }}</small></div>
                @enderror
            </div>
            
            <!-- Google reCaptcha Widget-->
            <div class="d-flex justify-content-center g-recaptcha mt-3 mb-3 " data-sitekey={{config('services.recaptcha.key')}}></div>

            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
            <p class="mt-5 mb-3 text-body-secondary text-center">Copyright &copy; Pusat Survei Geologi, 2024</p>
        </form>
    </main>

    {{-- Icon FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- JQuery Script --}}
    <script>
        $(document).ready(function() {
            $('.toggle-password-icon').on('click', function() {
                let passwordField = $(this).siblings('.form-control');
                let passwordFieldType = passwordField.attr('type');
                
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).children('.fa-eye').removeClass('fa-regular').addClass('fa-solid');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).children('.fa-eye').removeClass('fa-solid').addClass('fa-regular');
                }
            });

            $('.form-control').each(function() {
                if($(this).hasClass('is-invalid')) {
                    $(this).siblings('.toggle-password-icon').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
                }
            })
        });
    </script>
</body>
</html>