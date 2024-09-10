@extends('layout.master')

@section('content')

    <form action="/admin/sales/{{ $sale->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_name">User Name</label>
            <input type="text" class="form-control" id="user_name" value="{{ $sale->user->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" value="{{ $sale->product->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="text" class="form-control" id="total_harga" value="{{ $sale->total_harga }}" disabled>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="text" class="form-control" id="jumlah" value="{{ $sale->jumlah }}" disabled>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="PENDING" {{ $sale->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="COMPLETE" {{ $sale->status == 'COMPLETE' ? 'selected' : '' }}>COMPLETE</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Sale</button>
    </form>
@endsection
