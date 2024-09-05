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

    <title>{{ config('app.name') }} | Dashboard</title>
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
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}">Ubah Password</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-md mt-3">
        {{-- Pencarian --}}
        <form action="" class="position-relative">
            <input type="text" class="form-control border-primary-subtle" role="search" placeholder="Pencarian" aria-label="search" id="search" aria-describedby="search">
            <button type="submit" class="btn btn-focus position-absolute end-0 top-50 translate-middle-y" style="border-color: transparent">
                <i class="fa-solid fa-magnifying-glass fa-lg text-primary"></i>
            </button>
        </form>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('admin.create.dokumen') }}" class="rounded-3 btn btn-primary ">Dokumen Baru <i class="fa-solid fa-plus"></i></a>
            <nav aria-label="breadcrumb" class="align-middle">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item" aria-current="page"><a href="#" class="text-decoration-none">Home</a></li>
                </ol>
            </nav>
        </div>
        <div class="d-flex mt-3 mb-3 justify-content-between">
            <h5 class="fs-5 text-semibold">Daftar Dokumen</h5>
            <div>
                <a href="" class="py-1 px-2 text-black text-decoration-none rounded-5 me-3 me-sm-4 position-relative">
                    Proses
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-5 bg-danger">
                        +9
                        <span class="visually-hidden">unread document</span>
                    </span>
                </a>
                <a href="" class="bg-secondary-subtle py-1 px-2 text-black text-decoration-none rounded-5">Semua</a>
            </div>
        </div>
        <section class="row">
            <div class="col">
                {{-- Pengulangan Dokumen --}}
                @foreach($data_dokumen as $dataDokumen)
                    <div class="card mb-4">
                        <div class="card-header text-bg-warning fw-semibold">
                            <div class="row align-items-center">
                                <div class="col-10 col-sm-11">
                                    <div class="row g-1 g-sm-0">
                                        <div class="col-auto me-2 me-sm-0 col-sm-5">
                                            <i class="fa-regular fa-hourglass-half me-2"></i> {{ $dataDokumen->nomor_surat }}
                                        </div>
                                        <span class="badge rounded-pill text-bg-danger col-4 col-sm-2">Sisa hari: 3</span>
                                        <span class="text-secondary fw-normal col-12 col-sm-5 text-sm-end">{{ \Carbon\Carbon::parse($dataDokumen->tanggal_awal_dinas)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($dataDokumen->tanggal_akhir_dinas)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-2 col-sm-1 text-center">
                                    <a class="text-black toggle-icon" data-bs-toggle="collapse" href="#dokumen1" role="button" aria-expanded="false" aria-controls="dokumen1"><i class="fa-solid fa-angle-up"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="dokumen1">
                            {{-- Pengulangan Timeline --}}
                            <a href="{{ route('admin.status.dokumen') }}" class="text-decoration-none">
                                <div class="card-body row gy-2 justify-content-between">
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fa-solid fa-square-check fa-2xl text-success"></i>
                                            </div>
                                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                                <span class="fw-medium text-black mb-1">Pengajuan Nota Dinas</span>
                                                <small class="text-secondary link-offset-1 text-decoration-underline fw-normal" style="font-size: .8rem">Pengajuan ditolak karena tidak memenuhi kriteria pengajuan. Mohon Ajukan ulang</small>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-auto">
                                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                                            <span class="fw-medium text-black">(Admin SPPD 1)</span>
                                            <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">10 Agustus 2024 10:00</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card-footer text-dark-emphasis" style="background-color: rgba(217, 217, 217, 1);">{{ $dataDokumen->tim_teknis }}</div>
                    </div>
                @endforeach

                <div class="card mb-4">
                    <div class="card-header text-bg-success fw-semibold">
                        <div class="row align-items-center">
                            <div class="col-10 col-sm-11">
                                <div class="row g-1 g-sm-0">
                                    <div class="col-12 col-sm-6">
                                        <i class="fa-solid fa-check-double me-2"></i> SI/2024/001-002
                                    </div>
                                    <span class="text-white fw-normal col-12 col-sm-6 text-sm-end">10/8/2024 s.d. 11/8/2024</span>
                                </div>
                            </div>
                            <div class="col-2 col-sm-1 text-center">
                                <a class="text-black toggle-icon" data-bs-toggle="collapse" href="#dokumen2" role="button" aria-expanded="false" aria-controls="dokumen2"><i class="fa-solid fa-angle-up text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="dokumen2">
                        {{-- Pengulangan Timeline --}}
                        <a href="/ubahstatus" class="text-decoration-none">
                            <div class="card-body row gy-2 justify-content-between">
                                <div class="col-12 col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fa-solid fa-square-check fa-2xl text-success"></i>
                                        </div>
                                        <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                            <span class="fw-medium text-black mb-1">Pengajuan Nota Dinas</span>
                                            <small class="text-secondary link-offset-1 text-decoration-underline fw-normal" style="font-size: .8rem">10 Agustus 2024 10:00</small>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                                        <span class="fw-medium text-black">(Admin SPPD 1)</span>
                                        <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">10 Agustus 2024 10:00</small>
                                    </div>
                                </div>
                            </div>
                        </a> 
                    </div>
                    <div class="card-footer text-dark-emphasis" style="background-color: rgba(217, 217, 217, 1);">Urusan Umum dan Kepegawaian - Sistem Informasi</div>
                </div>
            </div>
        </section>
        {{-- Pagination --}}
        <div id="pagination-links"></div>
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

        // Rotasi arah panah ketika di klik
        document.querySelectorAll('.toggle-icon').forEach(function(e) {
            e.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('rotate-icon');
            });
        });
    </script>
</body>
</html>