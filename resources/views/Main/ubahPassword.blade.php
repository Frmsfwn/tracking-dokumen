<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Index Page for Tracking Document">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Custom CSS --}}
    <style>

        .end-reveal {
            right: 1rem;
        }

        .top-reveal {
            top: 1.9rem;
        }

        @media screen and (min-width: 992px) {
            .w-lg-50 {
                width: 50% !important;
            }
        }

        @media screen and (min-width: 1400px) {
            .w-xxl-25 {
                width: 25% !important;
            }
        }

        @media (min-width: 768px) {
            .fs-md-4 {
                font-size: calc(1.275rem + 0.3vw) !important;
            }
        }

        @media (min-width: 992px) {
            .container-md {
                max-width: 720px !important;
            }
        }
    </style>

    <title>{{ config('app.name') }} | Ubah Password</title>
</head>
<body class="m-sm-3 mt-2 mx-1">
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="container-md">
            <span class="navbar-brand mb-0 fs-5 fs-md-4 me-2 me-sm-3"><i class="fa-regular fa-clock fa-sm me-2"></i>Document Tracking - PSG</span>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-body-secondary fw-medium text-capitalize" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end">                    
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-md mt-3 ">        
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <a href="/" class="btn btn-secondary px-4"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
            <h5 class="fs-5 text-semibold"><i class="fa-solid fa-lock"></i> Ubah Password</h5>   
        </div>
        
        <section class="card p-4 pt-5 border-3">
            <form action="{{ route('update.password', ['User' => Auth::user()]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input type="password" name="password_lama" id="password_lama" aria-label="password_lama" @if($errors->hasBag('ubah_password')) value="{{ old('password_lama') }}" @endif maxlength="50" autocomplete="off" autocapitalize="off" class="form-control border-2 @if($errors->ubah_password->has('password_lama')) border-danger @else border-primary @endif  @error('password_lama', 'ubah_password') is-invalid @enderror" @required(true)>
                <label for="password_lama">Password Saat Ini<span class="text-danger">*</span></label>
                <span class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg"></i>
                </span>
                @error('password_lama', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('password_lama') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password_baru" id="password_baru" aria-label="password_baru" @if($errors->hasBag('ubah_password')) value="{{ old('password_baru') }}" @endif maxlength="50" autocomplete="off" autocapitalize="off" class="form-control border-2 @if($errors->ubah_password->has('password_baru')) border-danger @else border-primary @endif  @error('password_baru', 'ubah_password') is-invalid @enderror" @required(true)>
                <label  for="password_baru">Password Baru<span class="text-danger">*</span></label>
                <span class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg"></i>
                </span>
                @error('password_baru', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('password_baru') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" aria-label="konfirmasi_password" maxlength="50" autocomplete="off" autocapitalize="off" class="form-control border-2 @if($errors->ubah_password->has('konfirmasi_password')) border-danger @else border-primary @endif  @error('konfirmasi_password', 'ubah_password') is-invalid @enderror" @required(true)>
                <label for="konfirmasi_password">Konfirmasi Password<span class="text-danger">*</span></label>
                <span class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg"></i>
                </span>
                @error('konfirmasi_password', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('konfirmasi_password') }}</small></div>
                @enderror
            </div>
            <div class="w-100 d-flex justify-content-end ">
                <a class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#konfirmasiButton">Ubah <i class="fa-solid fa-chevron-right"></i></a>
            </div>
                
            {{-- Confirmation Modal --}}
            <div class="modal fade" id="konfirmasiButton" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="ubahLabel">Ubah Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <strong>Apakah anda yakin ingin mengubah Password?</strong><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Ubah <i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </section>
        {{-- Pagination --}}
        <div id="pagination-links"></div>
    </main>
    <footer class="footer fixed-bottom m-3 fw-medium text-secondary text-center">Copyright &copy; Pusat Survei Geologi, 2024</footer>

    {{-- Icon FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- Javascript --}}
    <script>
        // Ubah posisi footer tergantung pada panjang body
        function updateFooterPosition() {
            const bodyHeight = document.body.scrollHeight;
            const viewportHeight = window.innerHeight;
            const footer = document.querySelector('.footer');

            if (bodyHeight > viewportHeight) {
                footer.classList.remove('fixed-bottom');
                footer.classList.add('position-static');
            } else {
                footer.classList.remove('position-static');
                footer.classList.add('fixed-bottom');
            }
        }

        // Jalankan Listener ketika website di load atau berubah ukuran
        window.addEventListener('load', updateFooterPosition);
        window.addEventListener('resize', updateFooterPosition);
    </script>
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