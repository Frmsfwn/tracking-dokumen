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

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>{{ config('app.name') }} | Status Dokumen</title>
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
                    <li><a class="dropdown-item" href="{{ route('superAdmin.show.user') }}">Data User</a></li>
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}">Ubah Password</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-md mt-3">
        {{-- Pencarian --}}
        <form action="/superAdmin/homepage" class="position-relative">
            <input type="text" class="form-control border-primary-subtle" name="keyword" role="search" placeholder="Cari dokumen" aria-label="search" id="search" aria-describedby="search">
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
        <section class="card border-1 border-primary-subtle" id="printableCard">
            <div class="card-header bg-secondary fw-semibold pb-1" style="--bs-bg-opacity: .2;">
                <div class="d-flex justify-content-between">                                           
                    <h5 class="text-black">Status</h5>                    
                    <div class="text-end">
                        <span class="text-black text-opacity-75">{{ $data_dokumen->nomor_surat }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body "> 
                @foreach($data_tracking as $dataTracking)
                    <div class="row gy-2 justify-content-between mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="@if($dataTracking->opsi === null) fa-solid fa-square-check fa-2xl text-secondary @elseif($dataTracking->opsi === 'perbaiki') fa-solid fa-square-xmark fa-2xl text-danger @elseif($dataTracking->opsi === 'setuju') fa-solid fa-square-check fa-2xl text-success @endif"></i>
                                </div>
                                <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                    <span class="fw-medium text-black mb-1">{{ $dataTracking->status_dokumen }}</span> 
                                    @if($dataTracking->opsi === 'perbaiki')
                                        <small class="text-secondary link-offset-1 text-decoration-underline fw-normal" style="font-size: .8rem">{{ $dataTracking->catatan }}</small>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                                @if($dataTracking->opsi === null)

                                @else
                                    <span class="fw-medium text-black">({{ optional($dataTracking->admin)->nama }})</span>
                                    <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">{{ $dataTracking->updated_at->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') }}</small>            
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($data_dokumen->status === 'proses')
                <div class="w-100">
                    <a class="rounded-3 btn btn-danger w-auto" data-bs-toggle="modal" data-bs-target="#Hapus">Hapus <i class="fa-solid fa-trash-can"></i></a>
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
                                <form action="{{ route('superAdmin.delete.dokumen', ['Dokumen' => $data_dokumen]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-3 btn btn-danger">Hapus <i class="fa-solid fa-trash-can"></i></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="w-100 d-flex justify-content-between mt-5 no-print">
                    <a class="rounded-3 btn btn-danger w-auto" data-bs-toggle="modal" data-bs-target="#Hapus">Hapus <i class="fa-solid fa-trash-can"></i></a>
                    <button type="button" class="rounded-3 btn btn-primary w-auto" onclick="printCard('printableCard')">Print <i class="fa-solid fa-chevron-right"></i></i></a>
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
                                <form action="{{ route('superAdmin.delete.dokumen', ['Dokumen' => $data_dokumen]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-3 btn btn-danger">Hapus <i class="fa-solid fa-trash-can"></i></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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

        // Print card dokumen
        function printCard(cardId) {
            // Simpan content original
            const originalContent = $('body').html();

            // Ambil Id card
            $('#' + cardId + ' .no-print').detach();
            const printableContent = $('#' + cardId).clone();

            setTimeout(() => {
                // Timpa body dengan content print
                $('body').html(printableContent);
    
                // Print halaman
                window.print();
                $('body').html(originalContent);
            }, 500);

            // Mengembalikan halaman menjadi semula
            $('body').html(originalContent);
        }
    </script>
</body>
</html>