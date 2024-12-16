<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Pegawai</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 15px 15px 0 0;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-upload {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .btn-upload:hover {
            background-color: #0056b3;
        }

        #preview {
            width: 100%;
            max-width: 100%;
            border: 5px solid red;
            border-radius: 5px;
            background-color: #000;
            object-fit: cover;
        }

        /* Responsive Styles */
        @media (max-width: 576px) {
            .card {
                margin: 10px;
            }

            h5 {
                font-size: 16px;
            }

            .btn-upload {
                width: 100%;
                padding: 8px;
            }

            #preview {
                height: 100%;
                width: 100%;
            }
        }

        @media (min-width: 577px) and (max-width: 768px) {
            .card {
                margin: 20px;
            }

            #preview {
                height: 100%;
                width: 100%;
            }
        }

        @media (min-width: 769px) {
            #preview {
                height: 100%;
                width: 100%;
            }
        }
    </style>
</head>

<body>


    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Selamat Datang di Absensi Pegawai Kantor Camat SIAK HULU</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absensi.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Radio Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                   {{-- Error Validasi --}}
                                   @if ($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-6 d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="absensi"
                                                    value="hadir" id="hadir" required>
                                                <label class="form-check-label" for="hadir">Hadir</label>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="absensi"
                                                    value="sakit" id="sakit" required>
                                                <label class="form-check-label" for="sakit">Sakit</label>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="absensi" value="ijin"
                                                    id="izin" required>
                                                <label class="form-check-label" for="izin">Izin</label>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="absensi"
                                                    value="dinas" id="dinas" required>
                                                <label class="form-check-label" for="dinas">Dinas</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="nip">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" required placeholder="Masukkan NIP Anda">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <!-- Upload Bukti -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="bukti">Upload Bukti</label>
                                            <input type="file" class="form-control" id="bukti" name="bukti">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <!-- QR Code Scanner -->
                                    <input type="hidden" id="token" name="token" required>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <div class="alert alert-success mt-3" id="alert-success"
                                                style="display: none; ">
                                                QR Code Berhasil Diverifikasi!
                                            </div>
                                            <div class="alert alert-danger mt-3" id="alert-danger"
                                                style="display: none;">
                                                Token QR Salah, Silakan Scan Ulang!
                                            </div>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row" style="margin-top: 70px;">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-upload mt-3" id="submit-button">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        // Ambil token dari backend Laravel (harus sesuai format JS)
        const $tokenCode = "{{ $tokenCode }}";

        function onScanSuccess(decodedText, decodedResult) {
            // Validasi Token QR Code
            if (decodedText !== $tokenCode) {
                console.log('Token Salah');
                document.getElementById('preview').style.border = '5px solid red';
                document.getElementById('alert-success').style.display = 'none';
                document.getElementById('alert-danger').style.display = 'block';
                document.getElementById('alert-danger').innerText = "Token QR Salah! Silakan Scan Ulang.";
                return;
            }

            // Jika Token Benar
            console.log('Token Benar');
            document.getElementById('token').value = decodedText;
            document.getElementById('preview').style.border = '5px solid green';
            document.getElementById('alert-success').style.display = 'block';
            document.getElementById('alert-danger').style.display = 'none';
        }

        // Inisialisasi QR Code Scanner
        const html5QrCode = new Html5Qrcode("preview");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        ).catch(err => {
            console.error("Tidak bisa memulai scanner:", err);
        });

        // Cek apakah semua form sudah diisi
    
    </script>
</body>

</html>