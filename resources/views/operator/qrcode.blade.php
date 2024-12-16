@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="page-description">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="row">
        <div class="col-md-2">
            <p class="mb-0">Simple</p>
            <a href="" id="container">{!! $simple !!}</a><br />
            <button id="download" class="mt-2 btn btn-info text-light" onclick="downloadSVG()">Download SVG</button>
        </div>
        <div class="col-md-2">
            <p class="mb-0">Color Change</p>
            {!! $changeColor !!}
        </div>
        <div class="col-md-2">
            <p class="mb-0">Background Color Change </p>
            {!! $changeBgColor !!}
        </div>


        <div class="col-md-2">
            <p class="mb-0">Style Square</p>
            {!! $styleSquare !!}
        </div>
        <div class="col-md-2">
            <p class="mb-0">Style Dot</p>
            {!! $styleDot !!}
        </div>
        <div class="col-md-2">
            <p class="mb-0">Style Round</p>
            {!! $styleRound !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid">
                <label for="" class="mt-3">Token</label>
                <a href="" class="btn btn-primary btn-sm mt-3">Download QR</a>
                <a href="{{ route('operator.generate-qrcode') }}" class="btn btn-outline-primary mt-3 btn-sm">Generate
                    New Qr Code</a>
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