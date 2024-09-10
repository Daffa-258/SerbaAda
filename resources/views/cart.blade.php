@extends('layout.master2')

@section('content')
<section id="cart" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-4">Your Cart</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($carts->isEmpty())
            <p class="text-center">Your cart is empty.</p>
        @else
            <div class="row">
                @foreach ($carts as $cart)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg border-0">
                            <!-- Gambar Produk -->
                            <img src="{{ asset('storage/' . $cart->product->foto) }}" class="card-img-top" alt="{{ $cart->product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $cart->product->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($cart->product->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Harga Produk -->
                                    <span class="text-success fw-bold">Rp {{ number_format($cart->product->price, 2) }}</span>
                                </div>

                                <!-- Total Harga Produk Berdasarkan Quantity -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="text-muted">Total: </span>
                                    <span class="fw-bold text-success">Rp {{ number_format($cart->product->price * $cart->quantity, 2) }}</span>
                                </div>
                                
                                <!-- Counter Quantity -->
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                        <button type="submit" name="quantity" value="{{ $cart->quantity - 1 }}" class="btn btn-outline-secondary btn-sm me-2" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="mx-2">{{ $cart->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $cart->quantity + 1 }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Button Hapus dan Beli -->
                            <div class="card-footer text-center bg-transparent border-top-0">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                        <button type="submit" class="btn btn-danger w-45">Hapus</button>
                                    </form>

                                    <!-- Button Beli dengan SweetAlert -->
                                    <form action="{{ route('cart.buy') }}" method="POST" class="d-inline" id="buy-form-{{ $cart->id }}">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                        <button type="button" class="btn btn-primary w-45" onclick="confirmBuy(`{{ $cart->id }}`)">Beli</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- SweetAlert Konfirmasi Pembelian -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmBuy(cartId) {
        Swal.fire({
            title: 'Konfirmasi Pembelian',
            text: "Apakah Anda yakin ingin membeli produk ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Beli!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form pembelian
                document.getElementById('buy-form-' + cartId).submit();
            }
        });
    }

    @if (session('success_buy'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_buy') }}",
                confirmButtonText: 'Oke',
            })
        @endif
</script>
@endsection
