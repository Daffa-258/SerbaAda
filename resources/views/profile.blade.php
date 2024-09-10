@extends('layout.master2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="btn btn-danger d-block mb-2" style="width: 100%" href="/logout">logout</a>

            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/users/{{ $user->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="old_photo" value="{{ $user->foto }}">
                        <div class="text-center mb-4">
                            <img id="profile-preview" src="{{ asset($user->foto ? 'storage/'.$user->foto : 'img/user.jpg') }}" alt="Profile Image" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            <input type="file" id="profile-image" name="foto" class="form-control mt-2" onchange="previewImage(event)">
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label text-secondary mb-1">Name<span style="color:var(--error)">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-secondary mb-1">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary mb-1">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label text-secondary mb-1">Address</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_hp" class="form-label text-secondary mb-1">Phone Number</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}">
                            @error('no_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Menampilkan pesan jika ada session berhasil
    @if(session('success_update'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success_update') }}",
            confirmButtonText: 'Oke',
        })
    @endif
</script>
@endsection
