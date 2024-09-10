@extends('layout.master')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Sales</h6>
        </div>
        <div class="card-body">
            <form action="/admin/sales" method="GET"
                class="d-none d-sm-inline-block form-inline my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small"
                        placeholder="Search by user or product..." aria-label="Search" aria-describedby="basic-addon2">
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
                        <th>User Name</th>
                        <th>Product Name</th>
                        <th>Total Harga</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($dataSales as $sale)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td>{{ $sale->product->name }}</td>
                            <td>Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $sale->jumlah }}</td>
                            <td>{{ $sale->status }}</td>
                            <td>
                                <a href="/admin/sales/{{ $sale->id }}/edit" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger delete-button" data-id="{{ $sale->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form id="delete-form-{{ $sale->id }}"
                                    action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:none;">
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
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const saleId = button.getAttribute('data-id');

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
                        document.getElementById(`delete-form-${saleId}`).submit();
                    }
                });
            });
        });
    });

    @if (session('success_updated'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_updated') }}",
                confirmButtonText: 'Oke',
            });
        @endif

        @if (session('success_deleted'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_deleted') }}",
                confirmButtonText: 'Oke',
            });
        @endif
    </script>
@endsection
