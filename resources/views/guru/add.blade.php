@extends('layout.template')

@section('title','Tambah Guru')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form action="/guru/insert" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                    @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nama</label>
                    <input type="text" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror" id="exampleInputPassword1" value="{{ old('nama_guru') }}">
                    @error('nama_guru')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Matpel</label>
                    <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" id="exampleInputPassword1" value="{{ old('mapel') }}">
                    @error('mapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Foto</label>
                    <input type="file" name="foto_guru" class="form-control-file @error('foto_guru') is-invalid @enderror" id="exampleInputPassword1">
                    @error('foto_guru')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection