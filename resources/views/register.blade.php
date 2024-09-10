@extends('layout.master2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/users">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label text-secondary mb-1">Name<span
                                        style="color:var(--error)">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="Name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label text-secondary mb-1">Email<span
                                        style="color:var(--error)">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label text-secondary mb-1">Password<span
                                        style="color:var(--error)">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label text-secondary mb-1">Confirm Password<span
                                        style="color:var(--error)">*</span></label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password-confirm" placeholder="Confirm Password" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Sudah punya akun? <a href="/">Login di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Cek jika ada session berhasil
        @if(session('success_create'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_create') }}",
                confirmButtonText: 'Oke',
            })
        @endif
    </script>
@endsection
