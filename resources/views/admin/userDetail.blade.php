@extends('layout.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img id="profile-preview" src="{{ asset($user->foto ? 'storage/'.$user->foto : 'img/user.jpg') }}" alt="Profile Image" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label text-secondary mb-1">Name:</label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label text-secondary mb-1">Email:</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-secondary mb-1">Password:</label>
                        <p class="form-control-static">********</p> <!-- Menampilkan sebagai bintang atau bisa disesuaikan -->
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label text-secondary mb-1">Address:</label>
                        <p class="form-control-static">{{ $user->alamat }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="no_hp" class="form-label text-secondary mb-1">Phone Number:</label>
                        <p class="form-control-static">{{ $user->no_hp }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection