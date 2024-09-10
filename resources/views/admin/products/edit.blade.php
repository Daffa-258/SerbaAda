@extends('layout.master')

@section('content')
<h1>{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h1>

<form action="{{ isset($product) ? '/admin/products/' . $product->id : url('/admin/products') }}" method="POST" enctype="multipart/form-data">
    @csrf

        @method('PUT')
    

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="foto">Foto:</label>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>

    <div class="form-group">
        <label for="category_id">Category:</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }}</button>
</form>
@endsection
