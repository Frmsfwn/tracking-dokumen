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
                    <h5 class="text-black">Ubah Status</h5>                    
                    <div class="text-end">
                        <span class="text-black text-opacity-50">{{ $data_dokumen->nomor_surat }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                {{-- FORM --}}
                <form action="{{ route('admin.update.status', ['Dokumen' => $data_dokumen]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $previousItem = null;
                    @endphp
                    @foreach($data_tracking as $dataTracking)
                        <div class="row gy-2 justify-content-between mb-3">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="@if($dataTracking->opsi === null) fa-solid fa-square-check fa-2xl text-secondary @elseif($dataTracking->opsi === 'perbaiki') fa-solid fa-square-xmark fa-2xl text-danger @elseif($dataTracking->opsi === 'setuju') fa-solid fa-square-check fa-2xl text-success @endif"></i>
                                    </div>
                                    <h5 class="card-title link-offset-1 flex-grow-1 d-flex flex-column ms-3">
                                        <span class="fw-medium text-black mb-1">{{ $dataTracking->status_dokumen }}</span> 
                                    </h5>
                                </div>
                            </div>
                            @php
                                $id_tracking = $dataTracking->id;
                            @endphp
                            <div class="col-12 col-sm-auto">
                                <div class="d-flex ms-4 ps-3 ms-sm-0 ps-sm-0 flex-column">
                                    @if($previousItem !== null)
                                        @if($previousItem->opsi === null)

                                        @elseif($previousItem->opsi === 'perbaiki')

                                        @else
                                            @if($dataTracking->opsi === null)
                                                <select class="form-select bg-secondary" name="opsi" id="opsi" style="--bs-bg-opacity: .2;">
                                                    <option value="setuju" default selected>Setuju</option>
                                                    <option value="perbaiki">Perbaiki</option>
                                                </select>
                                                <input type="hidden" id="id_tracking" name="id_tracking" value="{{ $dataTracking->id }}">
                                            @elseif($dataTracking->opsi === 'perbaiki')
                                                <select class="form-select bg-secondary" name="opsi" id="opsi" style="--bs-bg-opacity: .2;">
                                                    <option value="setuju" default selected>Setuju</option>
                                                    <option value="perbaiki">Perbaiki</option>
                                                </select>
                                                <input type="hidden" id="id_tracking" name="id_tracking" value="{{ $dataTracking->id }}">
                                            @else
                                                <span class="fw-medium text-black">({{ optional($dataTracking->admin)->nama }})</span>
                                                <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">{{ $dataTracking->updated_at->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') }}</small>
                                            @endif
                                        @endif
                                    @else
                                        <span class="fw-medium text-black">({{ optional($dataTracking->admin)->nama }})</span>
                                        <small class="text-secondary link-offset-1 text-decoration-underline" style="font-size: .8rem">{{ $dataTracking->updated_at->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('d M Y H:i') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="textareaContainer mb-3" style="display: none">
                            <textarea name="{{ $id_tracking }}" id="catatan" placeholder="Catatan" style="resize: none; height: 100px" class="form-control catatan border-2 border-primary-subtle @error('catatan', $dataTracking->id) is-invalid @enderror"></textarea>
                            @error('alasan', $dataTracking->id)
                                <div class="text-danger"><small>{{ $errors->{$dataTracking->id}->first('catatan') }}</small></div>
                            @enderror
                        </div>

                        @php
                            $previousItem = $dataTracking;
                        @endphp
                    @endforeach

                    <div class="w-100 d-flex justify-content-end mt-5">
                        <a class="rounded-3 btn btn-primary w-auto " data-bs-toggle="modal" data-bs-target="#konfirmasiButton">Submit <i class="fa-solid fa-chevron-right"></i></i></a>                   
                    </div>                
                    {{-- Confirmation Modal --}}
                    <div class="modal fade" id="konfirmasiButton" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="ubahLabel">Ubah Status</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <strong>Apakah anda yakin ingin Mengubah Status?</strong><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="rounded-3 btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="rounded-3 btn btn-primary">Submit <i class="fa-solid fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

        // JQuery Code
        // Memunculkan textarea ketika opsi perbaiki dipilih
        $(document).ready(function() {
            $('.form-select').change(function() {
                // Cari Textarea terdekat dari select yang dipilih
                const container = $(this).closest('.mb-3').next('.textareaContainer');
                const textarea = container.find('.catatan');
                
                if ($(this).val() === 'perbaiki') {
                    container.show();
                    textarea.prop('required', true);
                } else {
                    container.hide();
                    textarea.prop('required', false);
                }
            });
        });
    </script>
</body>
</html>