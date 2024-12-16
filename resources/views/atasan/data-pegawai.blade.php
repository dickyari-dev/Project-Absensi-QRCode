@extends('layouts.app')


@section('active-pegawai', 'active-page')
@section('content')
<div class="row">
    <div class="col">
        <div class="page-description">
            <h5>Data Pegawai</h5>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Button trigger modal -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Pangkat</th>
                                <th>Gol.Ruang</th>
                                <th>Email</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPegawai as $item)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$item->employee->foto) }}" alt="Photo"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->employee->nip }}</td>
                                <td>{{ $item->employee->pangkat }}</td>
                                <td>{{ $item->employee->gol_ruang }}</td>
                                <td>{{ $item->email }}</td>
                              
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection