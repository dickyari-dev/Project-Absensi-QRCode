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
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Pegawai
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('operator.store-pegawai') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" id="photo" class="form-control" required
                                            placeholder="Photo">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" id="name" class="form-control" required
                                            placeholder="Nama">
                                    </div>
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" name="nip" id="nip" class="form-control" required
                                            placeholder="NIP">
                                    </div>
                                    <div class="form-group">
                                        <label for="pangkat">Pangkat</label>
                                        <input type="text" name="pangkat" id="pangkat" class="form-control" required
                                            placeholder="Pangkat">
                                    </div>
                                    <div class="form-group">
                                        <label for="gol_ruang">Gol.Ruang</label>
                                        <input type="text" name="gol_ruang" id="gol_ruang" class="form-control" required
                                            placeholder="Gol.Ruang">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            required placeholder="Password">
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <th>Action</th>
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
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $item->id }}">
                                        Edit
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="updateModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="updateModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('operator.update-pegawai') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Edit Pegawai</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="photo">Photo</label>
                                                            <input type="hidden" name="id" id="id"
                                                                value="{{ $item->id }}">
                                                            <input type="file" name="photo" id="photo"
                                                                class="form-control" placeholder="Photo"
                                                                accept="image/*">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Nama</label>
                                                            <input type="text" name="name" id="name"
                                                                class="form-control" required placeholder="Nama"
                                                                value="{{ $item->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nip">NIP</label>
                                                            <input type="text" name="nip" id="nip" class="form-control"
                                                                required placeholder="NIP"
                                                                value="{{ $item->employee->nip }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pangkat">Pangkat</label>
                                                            <input type="text" name="pangkat" id="pangkat"
                                                                class="form-control" required placeholder="Pangkat"
                                                                value="{{ $item->employee->pangkat }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="gol_ruang">Gol.Ruang</label>
                                                            <input type="text" name="gol_ruang" id="gol_ruang"
                                                                class="form-control" required placeholder="Gol.Ruang"
                                                                value="{{ $item->employee->gol_ruang }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" name="email" id="email"
                                                                class="form-control" required placeholder="Email"
                                                                value="{{ $item->email }}">
                                                        </div>
                                                        {{-- password --}}
                                                        <div class="form-group">
                                                            <label for="password">Password</label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control" placeholder="Password">
                                                            <small class="text-muted">Kosongkan jika tidak ingin
                                                                mengganti password</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $item->id }}">
                                        Hapus
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Pegawai</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus pegawai ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a href="{{ route('operator.delete-pegawai', $item->id) }}" type="button" class="btn btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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