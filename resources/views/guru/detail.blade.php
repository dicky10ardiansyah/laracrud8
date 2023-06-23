@extends('layout.template')

@section('title', 'Detail Guru')

@section('content')

<!-- Profile Image -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="{{ url('foto_guru/' . $guru->foto_guru) }}" alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">NIP: {{ $guru->nip }}</h3>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Nama Guru:</b> <a class="float-right">NIP: {{ $guru->nip }}</a>
          </li>
          <li class="list-group-item">
            <b>Mata Pelajaran:</b> <a class="float-right">{{ $guru->mapel }}</a>
          </li>
        </ul>

        <a href="/guru" class="btn btn-primary btn-block">Kembali</a>
      </div>
    </div>
  </div>
</div>


@endsection