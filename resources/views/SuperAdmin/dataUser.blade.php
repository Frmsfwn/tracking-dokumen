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
        .end-reveal {
            right: 1rem;
        }

        .top-reveal {
            top: 1.3rem;
        }
    </style>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    <title>{{ config('app.name') }} | Data User</title>
</head>
<body>
    <a href="/" class="btn btn-secondary" >Kembali</a>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">NIP</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col" colspan="2">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data_user as $dataUser)
                <tr>
                    <td>{{ $dataUser->nip }}</td>
                    <td>{{ $dataUser->nama }}</td>
                    <td>{{ $dataUser->username }}</td>
                    <td>{{ $dataUser->role }}</td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataUser->id }}">Ubah</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataUser->id }}">Hapus</button>
                    </td>
                </tr>
            @empty
                <h2>Data Kosong!</h2>
            @endforelse
        </tbody>
    </table>

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
                                <option value="Admin" @selected(old('version') === 'Admin')>Admin</option>
                                <option value="PIC" @selected(old('version') === 'PIC')>PIC</option>
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