@extends('layout.master')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="/admin/categories/create" class="btn btn-primary mb-3">Add Category</a>

            <h6 class="m-0 font-weight-bold text-primary">DataTables Categories</h6>
        </div>
        <div class="card-body">
            <!-- Topbar Search -->
            <form action="/admin/categories" method="GET" class="d-none d-sm-inline-block form-inline my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search by name or description..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
          

            <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataCategories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <!-- Button Show -->
                                <a href="/admin/categories/{{ $category->id }}" class="btn btn-primary" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
        
                                <!-- Button Edit -->
                                <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
        
                                <!-- Button Delete -->
                                <button class="btn btn-danger delete-button" data-id="{{ $category->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
        
                                <!-- Form Delete -->
                                <form id="delete-form-{{ $category->id }}" action="/admin/categories/{{ $category->id }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mengambil semua tombol hapus dengan class 'delete-button'
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah form submit langsung

                    // Mengambil ID dari data-id button yang diklik
                    const userId = button.getAttribute('data-id');

                    // Menampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika user mengkonfirmasi, submit form hapus
                            document.getElementById(`delete-form-${userId}`).submit();
                        }
                    });
                });
            });
        });
        @if (session('login_admin'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('login_admin') }}",
                confirmButtonText: 'Oke',
            })
        @endif
        @if (session('success_delete'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_delete')}}",
                confirmButtonText: 'Oke',
            })
        @endif
        @if (session('success_created'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_created')}}",
                confirmButtonText: 'Oke',
            })
        @endif
        @if (session('success_updated'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_updated')}}",
                confirmButtonText: 'Oke',
            })
        @endif
        @if (session('success_deleted'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_deleted')}}",
                confirmButtonText: 'Oke',
            })
        @endif
    </script>
@endsection
