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
                    admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('superAdmin.show.user') }}">Data User</a></li>
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
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <a href="/" class="rounded-3 btn btn-secondary px-4"><i class="fa-solid fa-chevron-left"></i> Kembali</a>            
            <nav aria-label="breadcrumb" class="align-middle ms-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item" ><a href="/" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Status Dokumen</li>
                </ol>
            </nav>
        </div>                
        <section class="card border-1 border-primary-subtle">
            <div class="card-header bg-secondary fw-semibold pb-1" style="--bs-bg-opacity: .2;">
                <div class="d-flex justify-content-between">                                           
                    <h5 class="text-black">Status</h5>                    
                    <div class="text-end">
                        <span class="text-black text-opacity-50">SI/2024/001-001</span>
                    </div>
                </div>
            </div>
            <div class="card-body ">                
                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-success"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Pengajuan Nota Dinas</span>                                
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

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-success"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Pengajuan Surat Dinas</span>                                
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

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-secondary"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Pembuatan Rampung</span>                                
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fs-3">-</span>
                        </div>
                    </div>                                        
                </div>

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-secondary"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Penandatanganan Rampung</span>                                
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fs-3">-</span>
                        </div>
                    </div>                    
                </div>

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-secondary"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Penandatanganan PPK</span>                                
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fs-3">-</span>
                        </div>
                    </div>                    
                </div>

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-secondary"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Penandatanganan Kabag Umum</span>                                
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fs-3">-</span>
                        </div>
                    </div>                    
                </div>

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-check fa-2xl text-secondary"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Proses SPBY</span>                                
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fs-3">-</span>
                        </div>
                    </div>                     
                </div>

                <div class="row gy-2 justify-content-between mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-square-xmark fa-2xl text-danger"></i>
                            </div>
                            <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                <span class="fw-medium text-black mb-1">Proses Transfer</span>                                
                                <small class="text-secondary link-offset-1 text-decoration-underline fw-normal" style="font-size: .8rem">Pengajuan ditolak karena tidak memenuhi kriteria pengajuan. Mohon Ajukan ulang</small>
                            </h5>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                            <span class="fw-medium text-black">(Admin Keuangan)</span>
                            <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">10 Agustus 2024 10:00</small>
                        </div>
                    </div>                     
                </div>
                <div class="w-100 d-flex justify-content-between">
                    <a class="rounded-3 btn btn-danger w-auto" data-bs-toggle="modal" data-bs-target="#Hapus">Hapus <i class="fa-solid fa-trash-can"></i></i></a>
                </div>                                
                {{-- Delete Modal --}}
                <div class="modal fade" id="Hapus" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ubahLabel">Hapus dokumen</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <strong>Apakah anda yakin ingin mnghapus Dokumen?</strong><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="rounded-3 btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                <form action="">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="rounded-3 btn btn-danger">Hapus <i class="fa-solid fa-trash-can"></i></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
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