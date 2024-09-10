@extends('layout.master2')

@section('content')
<section id="history" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-4">Riwayat Pembelian Anda</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($sales->isEmpty())
            <p class="text-center">Anda belum memiliki riwayat pembelian yang diterima.</p>
        @else
            <div class="row">
                @foreach ($sales as $sale)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg border-0">
                            <!-- Gambar Produk -->
                            <img src="{{ asset('storage/' . $sale->product->foto) }}" class="card-img-top" alt="{{ $sale->product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $sale->product->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($sale->product->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Harga Produk -->
                                    <span class="text-success fw-bold">Rp {{ number_format($sale->product->price, 2) }}</span>
                                </div>

                                <!-- Total Harga Produk Berdasarkan Quantity -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="text-muted">Total: </span>
                                    <span class="fw-bold text-success">Rp {{ number_format($sale->total_harga, 2) }}</span>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="text-muted">Jumlah: </span>
                                    <span class="fw-bold">{{ $sale->jumlah }}</span>
                                </div>
                            </div>
                            
                            <div class="card-footer text-center bg-transparent border-top-0">
                                <span class="badge bg-success">Status: {{ $sale->status }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
