@extends('layout.master2')

@section('content')
    {{-- Section Hero --}}
    <section class="hero d-flex align-items-center justify-content-center text-center py-5"
        style="background: url('/img/bg.jpg') no-repeat center center; background-size: cover; height: 100vh;">
        <div class="container">
            <h1 class="display-4 text-white">Welcome to SerbaAda</h1>
            <p class="lead text-white">Your one-stop e-commerce solution for all your needs. Discover, shop, and enjoy a
                variety of products with us.</p>
            <a href="#about" class="btn btn-primary btn-lg mt-3">Learn More</a>
        </div>
    </section>

    {{-- Section About Us --}}
    {{-- Section About Us --}}
    <section id="about" class="about-us py-5"
        style="min-height: 80vh; background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white;">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 mb-4">
                    <h2 class="display-4">About SerbaAda</h2>
                    <p class="lead">Your trusted e-commerce platform offering a wide range of quality products at
                        competitive prices. We strive to provide the best shopping experience with top-notch customer
                        service.</p>
                    <hr class="my-4" style="border-color: white; border-width: 2px;">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 text-center mb-4">
                    <div class="card shadow-sm p-4 border-0" style="background-color: rgba(255, 255, 255, 0.2);">
                        <i class="fas fa-shipping-fast fa-3x mb-3"></i>
                        <h5>Fast Shipping</h5>
                        <p>Get your products delivered quickly and safely to your doorstep.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="card shadow-sm p-4 border-0" style="background-color: rgba(255, 255, 255, 0.2);">
                        <i class="fas fa-thumbs-up fa-3x mb-3"></i>
                        <h5>Quality Products</h5>
                        <p>We ensure the best quality for all the products we offer.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="card shadow-sm p-4 border-0" style="background-color: rgba(255, 255, 255, 0.2);">
                        <i class="fas fa-headset fa-3x mb-3"></i>
                        <h5>24/7 Support</h5>
                        <p>Our support team is always here to help you with your needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section Category --}}
    <section id="category" class="category py-5" style="background-color: #f8f9fa;">
        <div class="container text-center">
            <h2 class="mb-4">Our Categories</h2>
            <a href="/all-categories" class="btn btn-outline-primary mb-4">View All Categories</a> <!-- Tambahkan button -->
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg border-0"
                            style="border-radius: 15px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;">
                            <!-- Card Header dengan Ikon dan Efek Gradien -->
                            <div class="card-header text-white d-flex align-items-center justify-content-center"
                                style="background: linear-gradient(135deg, #6a11cb, #2575fc); height: 150px;">
                                <i class="fas fa-th-large fa-3x"></i> <!-- Ikon sebagai pengganti gambar -->
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 text-center">
                                <a href="{{ url('/categories/' . $category->id) }}"
                                    class="btn btn-outline-primary w-100">View Products</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- Section Product --}}
    <section id="product" class="product py-5" style="background-color: #f1f1f1;">
        <div class="container text-center">
            <h2 class="mb-4">Featured Products</h2>
            <a href="/all-products" class="btn btn-outline-secondary mb-4">View All Products</a>
            <!-- Button View All Products -->
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg border-0">
                            <!-- Gambar Produk -->
                            <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top" alt="{{ $product->name }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                <!-- Batasan deskripsi -->
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <!-- Harga Produk -->
                                    <span class="text-success fw-bold">Rp {{ number_format($product->price, 2) }}</span>
                                    <!-- Button Add to Cart dengan Icon -->
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- Badge untuk Stok Produk -->
                            @if ($product->stock > 0)
                                <div class="card-footer text-muted text-center">
                                    <span class="badge bg-success">In Stock: {{ $product->stock }}</span>
                                </div>
                            @else
                                <div class="card-footer text-muted text-center">
                                    <span class="badge bg-danger">Out of Stock</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    


    {{-- Section Footer --}}
    <footer class="footer py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">© 2024 SerbaAda. All rights reserved.</p>
        </div>
    </footer>

    {{-- SweetAlert for session message --}}
    <script>
        @if (session('login_user'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('login_user') }}",
                confirmButtonText: 'Oke',
            })
        @endif
        @if (session('success_addtocart'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_addtocart') }}",
                confirmButtonText: 'Oke',
            })
        @endif
    </script>
@endsection
