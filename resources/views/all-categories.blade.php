@extends('layout.master2')

@section('content')
<section id="categories" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-4">Explore Our Categories</h2>

        <!-- Search Input -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <form action="{{ url('/all-categories') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search categories..." aria-label="Search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
        

        <!-- Categories Cards -->
        <div class="row">
            @forelse ($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-lg border-0" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;">
                        <!-- Card Header dengan Ikon dan Efek Gradien -->
                        <div class="card-header text-white d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #6a11cb, #2575fc); height: 150px;">
                            <i class="fas fa-th-large fa-3x"></i> <!-- Ikon sebagai pengganti gambar -->
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 text-center">
                            <a href="{{ url('/categories/' . $category->id) }}" class="btn btn-outline-primary w-100">View Products</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Tambahkan sedikit CSS di bawah ini atau di file CSS Anda -->
<style>
    #categories .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    #categories .card-header i {
        animation: bounce 1s infinite;
    }
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>

@endsection
