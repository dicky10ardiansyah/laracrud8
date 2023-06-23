@extends('layout.template')

@section('title','Guru')

@section('content')

@if (session('pesan'))

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Selamat!',
        text: '{{ session("pesan") }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>

@endif

<div class="row container">
    <div class="col">
        <a href="/guru/print" target="_blank" class="btn btn-danger"><i class="fas fa-print"></i> Print PDF</a>
        <a href="/guru/excel" target="_blank" class="btn btn-success"><i class="fas fa-file-excel"></i> Print Excel</a>
        <a href="/guru/add" class="btn btn-primary"><i class="fas fa-users"></i> Tambah Guru</a>
        <div style="width: 100%; overflow-x: auto;" class="mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Mata Pelajaran</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guru as $g)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $g->nip }}</td>
                        <td>{{ $g->nama_guru }}</td>
                        <td>{{ $g->mapel }}</td>
                        <td><img class="rounded-sm" src="{{ url('foto_guru/' . $g->foto_guru) }}" width="100px"></td>
                        <td>
                            <a href="/guru/detail/{{ $g->id_guru }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="/guru/edit/{{ $g->id_guru }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="deleteConfirmation('{{ $g->id_guru }}')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Memasukkan library SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@foreach ($guru as $g)

<script>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Hapus Data',
            text: 'Apakah anda yakin ingin menghapus data {{ $g->nama_guru }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/guru/delete/" + id;
            }
        });
    }
</script>

@endforeach

@endsection