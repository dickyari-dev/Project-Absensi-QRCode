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



        #preview {
            width: 100%;
            max-width: 100%;
            border: 5px solid red;
            border-radius: 5px;
            background-color: #000;
            object-fit: cover;
            height: 200px;
        }

        video {
            width: 100%;
            object-fit: cover;
        }

        .modal-confirm {
            color: #636363;
            width: 325px;
            font-size: 14px;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -15px;
        }

        .modal-confirm .form-control,
        .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
        }

        .modal-confirm .icon-box {
            color: #fff;
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: -70px;
            width: 95px;
            height: 95px;
            border-radius: 50%;
            z-index: 9;
            background: #82ce34;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .modal-confirm .icon-box i {
            font-size: 58px;
            position: relative;
            top: 3px;
        }

        .modal-confirm.modal-dialog {
            margin-top: 80px;
        }

        .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            background: #82ce34;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border: none;
        }

        .modal-confirm .btn:hover,
        .modal-confirm .btn:focus {
            background: #6fb32b;
            outline: none;
        }

        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
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


    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center" style="background-color: #084f76; color: #fff;">
                <h5>Selamat Datang di Absensi Pegawai Kantor Camat SIAK HULU</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 py-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="" id="preview"></div>
                            </div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                        <div class="alert alert-success" id="alert-success" style="display: none;">
                            <strong>Success!</strong> Scan QR Code Berhasil.
                        </div>
                        <div class="alert alert-danger" id="alert-danger" style="display: none;">
                            <strong>Error!</strong> Scan QR x Tidak Dikenali.
                        </div>
                        <form action="{{ route('absensi.store') }}" onsubmit="return validateForm()" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <table class="table">
                                <input type="hidden" name="token" id="token">
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td><input type="text" name="nip" id="nip" class="form-control"
                                            onchange="getPegawai()">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Absensi</td>
                                    <td>:</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="absensi"
                                                        id="absensi_masuk" value="masuk" required>
                                                    <label class="form-check-label" for="absensi_masuk">Masuk</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="absensi"
                                                        id="absensi_sakit" value="sakit" required>
                                                    <label class="form-check-label" for="absensi_sakit">Sakit</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="absensi"
                                                        id="absensi_ijin" value="ijin" required>
                                                    <label class="form-check-label" for="absensi_ijin">Ijin</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="absensi"
                                                        id="absensi_dinas" value="dinas" required>
                                                    <label class="form-check-label" for="absensi_dinas">Dinas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bukti Absensi</td>
                                    <td>:</td>
                                    <td><input type="file" name="bukti_absensi" id="bukti_absensi" class="form-control">
                                        <span class="text-danger" style="font-size: 12px;">*Wajib Diisi Jika Absensi
                                            Sakit,
                                            Dinas, atau Ijin</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Pegawai</td>
                                    <td>:</td>
                                    <td><input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control"
                                            readonly style="background-color: #c9c9c9;" placeholder="Terisi Otomatis">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pangkat</td>
                                    <td>:</td>
                                    <td><input type="text" name="pangkat" id="pangkat" class="form-control" readonly
                                            style="background-color: #c9c9c9;" placeholder="Terisi Otomatis">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gol.Ruang</td>
                                    <td>:</td>
                                    <td><input type="text" name="gol_ruang" id="gol_ruang" class="form-control" readonly
                                            style="background-color: #c9c9c9;" placeholder="Terisi Otomatis">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn-primary">Submit Absensi</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box">
                        <i class="material-icons">&#xE876;</i>
                    </div>
                    <h4 class="modal-title w-100">Success!</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Absensi Berhasil. Terima Kasih.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        // JIka Button Submit Ditekan tapi belum QR 
        function validateForm() {
            // Cek apakah token QR Code sudah dipindai
            const token = document.getElementById('token').value;
            if (!token) {
                document.getElementById('alert-danger').style.display = 'block';
                document.getElementById('alert-danger').innerText = "Silakan scan QR Code terlebih dahulu sebelum mengirim.";
                setTimeout(() => {
                    document.getElementById('alert-danger').style.display = 'none';
                }, 3000);
                return false;
            }
            //    Jika NIP tidak diisi
            const nip = document.getElementById('nip').value;
            if (!nip) {
                document.getElementById('alert-danger').style.display = 'block';
                document.getElementById('alert-danger').innerText = "NIP tidak boleh kosong. Silakan isi NIP terlebih dahulu sebelum mengirim.";
                setTimeout(() => {
                    document.getElementById('alert-danger').style.display = 'none';
                }, 3000);
                return false;
            }

            // Cek apakah absensi tidak diisi
            const absensi = document.getElementById('absensi').value;
            if (!absensi) {
                document.getElementById('alert-danger').style.display = 'block';
                document.getElementById('alert-danger').innerText = "Absensi tidak boleh kosong. Silakan isi Absensi terlebih dahulu sebelum mengirim.";
                setTimeout(() => {
                    document.getElementById('alert-danger').style.display = 'none';
                }, 3000);
                return false;
            }
        }

        // Get Pegawai
        function getPegawai() {
            const nip = document.getElementById('nip').value;
            if (nip) {
                fetch(`/get-pegawai/${nip}`)
                    .then(response => {
                        if (!response.ok) {
                            document.getElementById('alert-danger').style.display = 'block';
                            document.getElementById('alert-danger').innerText = "Pegawai tidak ditemukan. Silakan periksa NIP yang dimasukkan.";
                            setTimeout(() => {
                                document.getElementById('alert-danger').style.display = 'none';
                            }, 3000);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update form fields with the fetched data
                        document.getElementById('nama_pegawai').value = data.nama || '';
                        document.getElementById('pangkat').value = data.pangkat || '';
                        document.getElementById('gol_ruang').value = data.gol_ruang || '';
                        document.getElementById('alert-success').style.display = 'block';
                        document.getElementById('alert-danger').style.display = 'none';
                        document.getElementById('alert-success').innerText = "Pegawai Berhasil Ditemukan.";
                        setTimeout(() => {
                            document.getElementById('alert-success').style.display = 'none';
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        document.getElementById('alert-success').style.display = 'none';
                        document.getElementById('alert-danger').style.display = 'block';
                        document.getElementById('alert-danger').innerText = "Pegawai tidak ditemukan. Silakan periksa NIP yang dimasukkan.";
                        setTimeout(() => {
                            document.getElementById('alert-danger').style.display = 'none';
                        }, 3000);
                    });
            }
        }
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

        // Tambahkan event listener pada tombol submit
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Mencegah pengiriman jika validasi gagal
            }
        });
    </script>
</body>

</html>