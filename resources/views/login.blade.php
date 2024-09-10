@extends('layout.master2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf

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

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Belum punya akun? <a href="/admin/users/create">Daftar di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cek jika ada session berhasil


    </script>
@endsection
