@extends('layout.template')

@section('title','Edit Guru')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form action="/guru/update/{{ $guru->id_guru }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ $guru->nip }}" id="exampleInputEmail1" aria-describedby="emailHelp" readonly>
                    @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nama</label>
                    <input type="text" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror" value="{{ $guru->nama_guru }}" id="exampleInputPassword1" value="{{ old('nama_guru') }}">
                    @error('nama_guru')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Matpel</label>
                    <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" value="{{ $guru->mapel }}" id="exampleInputPassword1" value="{{ old('mapel') }}">
                    @error('mapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ url('foto_guru/' . $guru->foto_guru) }}" width="100px">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ganti Foto</label>
                            <input type="file" name="foto_guru" class="form-control-file @error('foto_guru') is-invalid @enderror" id="exampleInputPassword1">
                            @error('foto_guru')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection