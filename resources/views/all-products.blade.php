@extends('layout.master2')

@section('content')
<section id="products" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-4">Explore Our Products</h2>

        <!-- Search Input -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <form action="{{ url('/all-products') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search products..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- Products Cards -->
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;">
                        <!-- Gambar Produk -->
                        <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <p class="text-primary fw-bold">${{ number_format($product->price, 2) }}</p>
                            <span class="badge bg-success mb-2">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-primary w-100"><i class="fas fa-cart-plus me-2"></i>Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No products found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    #products .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
