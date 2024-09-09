<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Index Page for Tracking Document">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Custom CSS --}}
    <style>
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

    <title>{{ config('app.name') }} | Dokumen Baru</title>
</head>
<body class="m-sm-3 mt-2 mx-1">
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
        <form action="/admin/homepage" class="position-relative">
            <input type="text" class="form-control border-primary-subtle" name="keyword" role="search" placeholder="Pencarian" aria-label="search" id="search" aria-describedby="search">
            <button type="submit" class="btn btn-focus position-absolute end-0 top-50 translate-middle-y" style="border-color: transparent">
                <i class="fa-solid fa-magnifying-glass fa-lg text-primary"></i>
            </button>
        </form>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="/" class="rounded-3 btn btn-secondary px-4"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
            <nav aria-label="breadcrumb" class="align-middle">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item" ><a href="/" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dokumen Baru</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex mt-3 mb-3 justify-content-between">
            <h5 class="fs-5 text-semibold"><i class="fa-solid fa-file-circle-plus"></i> Dokumen Baru</h5>            
        </div>
        <section class="card p-4 border-3">
            <form action="{{ route('admin.store.dokumen') }}" method="POST">
                @csrf
                <div class="row mb-3">                    
                    <label class="col-sm-4 col-form-label">Nomor Surat Tugas<span class="text-danger">*</span></label>
                    <div class="col-sm">
                        <input type="text" name="nomor_surat_tugas" id="nomor_surat_tugas" @if($errors->hasBag('tambah_data')) value="{{ old('nomor_surat_tugas') }}" @endif maxlength="25" class="form-control border-2 @error('nomor_surat_tugas', 'tambah_data') is-invalid @enderror" @required(true)> 
                    </div>
                    @error('nomor_surat_tugas', 'tambah_data')
                        <div class="text-danger"><small>{{ $errors->tambah_data->first('nomor_surat_tugas') }}</small></div>
                    @enderror
                </div>
                <div class="row mb-3">                    
                    <label class="col-sm-4 col-form-label">Urusan / Tim Teknis<span class="text-danger">*</span></label>                    
                    <div class="col-sm">
                        <select name="tim_teknis" id="tim_teknis" class="form-select border-2 @error('tim_teknis', 'tambah_data') is-invalid @enderror" @required(true)>
                            <option value="Sistem Informasi dan Humas" @selected(old('tim_teknis') === 'Sistem Informasi dan Humas')>Sistem Informasi dan Humas</option>
                            <option value="Perpustakaan, Ketatausahaan dan Kearsipan" @selected(old('tim_teknis') === 'Perpustakaan, Ketatausahaan dan Kearsipan')>Perpustakaan, Ketatausahaan dan Kearsipan</option>
                            <option value="Perencanaan" @selected(old('tim_teknis') === 'Perencanaan')>Perencanaan</option>
                            <option value="Keuangan dan BMN" @selected(old('tim_teknis') === 'Keuangan dan BMN')>Keuangan dan BMN</option>
                            <option value="Perlengkapan dan Kerumahtanggaan" @selected(old('tim_teknis') === 'Perlengkapan dan Kerumahtanggaan')>Perlengkapan dan Kerumahtanggaan</option>
                            <option value="Hukum dan Kerjasama" @selected(old('tim_teknis') === 'Hukum dan Kerjasama')>Hukum dan Kerjasama</option>
                            <option value="Ortala dan Kepegawaian" @selected(old('tim_teknis') === 'Ortala dan Kepegawaian')>Ortala dan Kepegawaian</option>
                            <option value="Pemetaan Sistematik" @selected(old('tim_teknis') === 'Pemetaan Sistematik')>Pemetaan Sistematik</option>
                            <option value="Pemetaan Tematik" @selected(old('tim_teknis') === 'Pemetaan Tematik')>Pemetaan Tematik</option>
                            <option value="Survei Umum Migas" @selected(old('tim_teknis') === 'Survei Umum Migas')>Survei Umum Migas</option>
                            <option value="Rekomendasi Wilayah Keprospekan Migas" @selected(old('tim_teknis') === 'Rekomendasi Wilayah Keprospekan Migas')>Rekomendasi Wilayah Keprospekan Migas</option>
                            <option value="Geopark Nasional dan Pusat Informasi Geologi" @selected(old('tim_teknis') === 'Geopark Nasional dan Pusat Informasi Geologi')>Geopark Nasional dan  Pusat Informasi Geologi</option>
                            <option value="Warisan Geologi" @selected(old('tim_teknis') === 'Warisan Geologi')>Warisan Geologi</option>
                            <option value="Pengembangan Konsep Geosains" @selected(old('tim_teknis') === 'Pengembangan Konsep Geosains')>Pengembangan Konsep Geosains</option>
                        </select>
                    </div>
                    @error('tim_teknis', 'tambah_data')
                        <div class="text-danger text-start"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Tanggal Dinas</label>
                    <div class="col-sm-3 col-12">
                        <input type="date" name="tanggal_awal_dinas" id="tanggal_awal_dinas" @if($errors->hasBag('tambah_data')) value="{{ old('tanggal_awal_dinas') }}" @endif class="form-control border-2 @error('tanggal_awal_dinas', 'tambah_data') is-invalid @enderror" @required(true)> 
                        @error('tanggal_awal_dinas', 'tambah_data')
                            <div class="text-danger"><small>{{ $errors->tambah_data->first('taanggal_awal_dinas') }}</small></div>
                        @enderror
                    </div>
                    <div class="col-sm-1 col-12">
                        <p class="text-center mt-2">s.d.</p>
                    </div>
                    <div class="col-sm-3 col-12">
                        <input type="date" name="tanggal_akhir_dinas" id="tanggal_akhir_dinas" @if($errors->hasBag('tambah_data')) value="{{ old('tanggal_akhir_dinas') }}" @endif class="form-control border-2 @error('tanggal_akhir_dinas', 'tambah_data') is-invalid @enderror" @required(true)> 
                        @error('tanggal_akhir_dinas', 'tambah_data')
                            <div class="text-danger"><small>{{ $errors->tambah_data->first('tanggal_akhir_dinas') }}</small></div>
                        @enderror
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-end">
                    <button  type="submit" class="rounded-3 btn btn-primary ">Submit <i class="fa-solid fa-chevron-right"></i></button>                
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
</body>
</html>