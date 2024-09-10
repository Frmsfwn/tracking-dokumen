<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  
    {{-- Custom CSS --}}
    <style>
        .btn-hover:hover {
            background-color: #aaa !important;
            transition: 200ms;
        }

        .end-reveal {
            right: 1rem;
        }

        .top-reveal {
            top: 1.3rem;
        }
        .rotate-icon {
            transform: rotate(180deg);
        }

        i.fa-solid {
            transition: transform 0.3s ease;
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

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    <title>{{ config('app.name') }} | Data User</title>
</head>
<body class="container-md mt-3">
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="container-md">
            <span class="navbar-brand mb-0 fs-5 fs-md-4 me-2 me-sm-3"><i class="fa-regular fa-clock fa-sm me-2"></i>Document Tracking - PSG</span>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-body-secondary fw-medium text-capitalize" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}">Ubah Password</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-md mt-3">
        {{-- Pencarian --}}
        <form action="" class="position-relative">
            <input type="text" name="keyword" class="form-control border-primary-subtle" role="search" placeholder="Cari data User" aria-label="search" id="search" aria-describedby="search">
            <button type="submit" class="btn btn-focus position-absolute end-0 top-50 translate-middle-y" style="border-color: transparent">
                <i class="fa-solid fa-magnifying-glass fa-lg text-primary"></i>
            </button>
        </form>

        <div class="row mt-3 mb-3 justify-content-between">
            <div class="col-12 col-sm-4 ">
                <h5 class="fs-5 text-semibold">Daftar User</h5>
            </div>

            <div class="col-12 col-sm-8 text-sm-end">
                <a href="{{ route('superAdmin.show.user', ['filter' => 'admin']) }}"  class="@if ($filter == 'admin') bg-secondary-subtle  @endif btn-hover py-1 px-2 text-black text-decoration-none rounded-5">Admin</a>
                <a href="{{ route('superAdmin.show.user', ['filter' => 'pic']) }}" class="@if ($filter == 'pic') bg-secondary-subtle  @endif btn-hover py-1 px-2 text-black text-decoration-none rounded-5">PIC</a>                                    
                <a href="{{ route('superAdmin.show.user', ['filter' => 'all']) }}" class="@if ($filter == 'all') bg-secondary-subtle  @endif btn-hover py-1 px-2 text-black text-decoration-none rounded-5 ">Semua</a>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <a href="/" class="btn btn-secondary rounded-3" ><i class="fa-solid fa-chevron-left "></i> Kembali</a>
            <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahData"><i class="fa-solid fa-user-plus"></i> Tambah Data</button>
        </div>
        <section class="row row-cols-1 row-cols-sm-2 g-2">
            {{-- card user admin --}}
            @forelse($data_user as $dataUser)
            <div class="col">
                <div class="card mb-4 border-2">
                    <a class="toggle-icon text-decoration-none" data-bs-toggle="collapse" href="#{{ $dataUser->nip }}" role="button" aria-expanded="false" aria-controls="dokumen1">
                        <div class="card-header bg-secondary-subtle fw-semibold " >
                            <div class="row align-items-center">
                                <div class="col-10 col-sm-10">                                
                                    <div class="d-grid ">
                                        <span class="text-black fs-5 ">{{ $dataUser->nama }}</span>
                                        <small class="text-black fw-medium text-decoration-underline" style="--bs-text-opacity: .6;">NIP : {{ $dataUser->nip }}</small>
                                    </div>                                    
                                </div>
                                <div class="col-2 col-sm-2 text-start ">
                                    <span class="text-black "><i class="fa-solid fa-angle-up fa-lg"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    

                        {{-- isi data admin --}}
                    <div class="collapse" id="{{$dataUser->nip }}">
                        <ul class="list-group list-group-flush">                                    
                            <li class="list-group-item">
                                <h5 class="card-title">Username :</h5> 
                                <h6 class="card-text">{{ $dataUser->username }}</h6>
                            </li>
                            <li class="list-group-item">
                                <h5 class="card-title">Role :</h5> 
                                <h6 class="card-text">{{ $dataUser->role }}</h6>
                            </li>                                             
                            <li class="list-group-item"> 
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-warning rounded-3 w-50 me-1" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataUser->id }}">Ubah</button>
                                    <button class="btn btn-danger rounded-3 w-50 ms-1" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataUser->id }}">Hapus</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @empty
                <h2 class="text-center w-100 text-secondary">Data Kosong!</h2>
            @endforelse
        </section>
        {{-- Pagination --}}
        <div id="pagination-links">{!! $data_user->links() !!}</div>
    </main>
    <footer class="footer z-n1 fixed-bottom m-3 fw-medium text-secondary text-center">Copyright &copy; Pusat Survei Geologi, 2024</footer>

    {{-- Icon FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- Javascript --}}
    <script>
        // Ubah posisi footer tergantung pada panjang body
        function updateFooterPosition() {
            const bodyHeight = document.body.scrollHeight;
            const viewportHeight = window.innerHeight;
            const footer = document.querySelector('.footer');

            if (bodyHeight >= viewportHeight) {
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

        // Rotasi arah panah ketika di klik
        document.querySelectorAll('.toggle-icon').forEach(function(e) {
            e.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('rotate-icon');
            });
        });
    </script>

    {{-- Modal Tambah Data User --}}
    <form action="{{ route('superAdmin.create.user') }}" method="POST" class="form-card">
        @csrf
        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container-fluid p-0 container-md">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex">
                                <strong class="text-start"><label for="nip_user" class="form-label">NIP<span class="text-danger">*</span></label></strong>
                                <input type="number" id="nip_user" name="nip_user" @if($errors->hasBag('tambah_data')) value="{{ old('nip_user') }}" @endif maxlength="25" class="form-control @error('nip_user', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('nip_user', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('nip_user') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex ">
                                <strong class="text-start"><label for="nama_user" class="form-label">Nama<span class="text-danger">*</span></label></strong>
                                <input type="text" id="nama_user" name="nama_user" @if($errors->hasBag('tambah_data')) value="{{ old('nama_user') }}" @endif maxlength="25" class="form-control @error('nama_user', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('nama_user', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_user') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex ">
                                <strong class="text-start"><label for="username" class="form-label">Username<span class="text-danger">*</span></label></strong>
                                <input type="text" id="username" name="username" @if($errors->hasBag('tambah_data')) value="{{ old('username') }}" @endif maxlength="25" class="form-control @error('username', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('username', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('username') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex ">
                                <strong class="text-start"><label for="password" class="form-label">Password<span class="text-danger">*</span></label></strong>
                                <div class="position-relative">
                                    <input type="password" id="password" name="password" @if($errors->hasBag('tambah_data')) value="{{ old('password') }}" @endif autocomplete="off" autocapitalize="off" maxlength="50" class="form-control @error('password', 'tambah_data') is-invalid @enderror" @required(true)>
                                    <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                                        <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                                    </span>
                                </div>
                                @error('password', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('password') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 flex-column d-flex">
                            <strong class="text-start"><label for="role" class="form-label">Role<span class="text-danger">*</span></label></strong>
                            <select id="role" name="role" class="form-select @error('role', 'tambah_data') is-invalid @enderror" @required(true)>
                                <option value="Admin" @selected(old('role') === 'Admin')>Admin</option>
                                <option value="PIC" @selected(old('role') === 'PIC')>PIC</option>
                            </select>
                            @error('role', 'tambah_data')
                                <div class="text-danger text-start"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @foreach($data_user as $dataUser)
        {{-- Modal Ubah Data User --}}
        <div class="modal fade" id="modalUbahData{{ $dataUser->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container-fluid p-0">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('superAdmin.update.user', ['User' => $dataUser]) }}" method="POST" class="form-card">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-between text-left mb-2">
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="nip_user" class="form-label">NIP<span class="text-danger">*</span></label></strong>
                                    <input type="number" id="nip_user" name="nip_user" @if($errors->hasBag($dataUser->id)) value="{{ old('nip_user') }}" @else value="{{ $dataUser->nip }}" @endif maxlength="25" class="form-control @error('nip_user', $dataUser->id) is-invalid @enderror" @required(true)>
                                    @error('nip_user', $dataUser->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataUser->id}->first('nip_user') }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="nama_user" class="form-label">Nama<span class="text-danger">*</span></label></strong>
                                    <input type="text" id="nama_user" name="nama_user" @if($errors->hasBag($dataUser->id)) value="{{ old('nama_user') }}" @else value="{{ $dataUser->nama }}" @endif maxlength="25" class="form-control @error('nama_user', $dataUser->id) is-invalid @enderror" @required(true)>
                                    @error('nama_user', $dataUser->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataUser->id}->first('nama_user') }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="username" class="form-label">Username<span class="text-danger">*</span></label></strong>
                                    <input type="text" id="username" name="username" @if($errors->hasBag($dataUser->id)) value="{{ old('username') }}" @else value="{{ $dataUser->username }}" @endif maxlength="25" class="form-control @error('username', $dataUser->id) is-invalid @enderror" @required(true)>
                                    @error('username', $dataUser->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataUser->id}->first('username') }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="password" class="form-label">Password<span class="text-danger">*</span></label></strong>
                                    <div class="position-relative">
                                        <input type="password" id="password" name="password" maxlength="25" class="form-control @error('password', $dataUser->id) is-invalid @enderror" @required(true)>
                                        <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                                            <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                                        </span>
                                    </div>
                                    @error('password', $dataUser->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataUser->id}->first('password') }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="role" class="form-label">Role<span class="text-danger">*</span></label></strong>
                                    <select id="role" name="role" class="form-select @error('role', $dataUser->id) is-invalid @enderror" @required(true)>
                                        <option value="Admin" @if($errors->hasBag($dataUser->id)) @selected(old('version') === 'Admin') @else @selected($dataUser->role === 'Admin') @endif>Admin</option>
                                        <option value="PIC" @if($errors->hasBag($dataUser->id)) @selected(old('version') === 'PIC') @else @selected($dataUser->role === 'PIC') @endif>PIC</option>        
                                    </select>
                                    @error('role', $dataUser->id)
                                        <div class="text-danger text-start"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Hapus Data User --}}
        <div class="modal fade" id="modalHapusData{{ $dataUser->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus data ini?<br>
                        <b>{{ $dataUser->nama }} (NIP:{{ $dataUser->nip }})</b>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('superAdmin.delete.user', ['User' => $dataUser]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->hasBag('tambah_data'))
                $('#modalTambahData').modal('show');
            @endif
        });

        @foreach($data_user as $dataUser)
            document.addEventListener('DOMContentLoaded', function () {
                @if ($errors->hasBag($dataUser->id))
                    $("#modalUbahData{{ $dataUser->id }}").modal('show');
                @endif
            });
        @endforeach

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