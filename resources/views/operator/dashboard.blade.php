@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="page-description">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">QR Code</h5>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                <a href="" id="container">{!! $qrCode !!}</a><br />
                <label for="" class="mt-3">Token : {{ $tokenCode }} </label>
                <label class="mb-3 text-muted"> Terakhir di update : {{ $token->updated_at->diffForHumans() }}</label>
                <div class="row">
                    <div class="col-md-6">
                        <button id="download" class="mt-2 btn btn-info text-light" onclick="downloadSVG()">Download
                            SVG</button>
                    </div>
                    <div class="col-md-6">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Generate QR Code Baru
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Generate QR Code Baru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda ingin membuat QR Code baru? Qr Code yang lama akan dihapus dan Tidak dapat digunakan lagi</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <a href="{{ route('operator.generate-qrcode') }}"
                                            class="btn btn-outline-primary">Generate
                                            New Qr Code</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function downloadSVG() {
      const svg = document.getElementById('container').innerHTML;
      const blob = new Blob([svg.toString()]);
      const element = document.createElement("a");
      element.download = "w3c.svg";
      element.href = window.URL.createObjectURL(blob);
      element.click();
      element.remove();
    }
</script>
@endsection