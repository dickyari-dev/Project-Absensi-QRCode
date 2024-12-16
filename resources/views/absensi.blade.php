<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Pegawai</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ asset('assets-landing/js/instascan.min.js') }}"></script>
    <style>
        /* Styling tambahan untuk mempercantik tampilan */
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

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
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
            color: #fff;
        }

        /* Styling untuk video */
        #preview {
            border: 5px solid #007bff;
            /* Tambahkan border dengan warna biru */
            border-radius: 15px;
            /* Membuat sudut video membulat */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Menambahkan bayangan untuk efek 3D */
            background-color: #000;
            /* Latar belakang hitam jika video tidak aktif */
            object-fit: cover;
            /* Video akan menyesuaikan area */
        }

        @media (max-width: 768px) {
            #preview {
                height: 250px;
            }
        }

        @media (min-width: 769px) {
            #preview {
                height: 350px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="" id="preview"></div>
            </div>
        </div>
    </div>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        // Get Pegawai
        let nip = document.getElementById('nip').value;
        fetch(`/get-pegawai/${nip}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('nama').value = data.nama;
                document.getElementById('pangkat').value = data.pangkat;
                document.getElementById('gol_ruang').value = data.gol_ruang;
                document.getElementById('jabatan').value = data.jabatan;
            });

        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
          console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
          if (cameras.length > 0) {
            scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(function (e) {
          console.error(e);
        });
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                let video = document.getElementById('preview');
                video.srcObject = stream;
                video.play();
            })
            .catch(function (err) {
                console.error('Error accessing camera: ', err);
            });
    </script>
</body>

</html>