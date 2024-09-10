<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $description = 'Tabel sales digunakan untuk mencatat transaksi penjualan yang melibatkan pengguna dan produk.';

        $search = $request->input('search');

        // Query untuk mencari sales berdasarkan nama user atau nama produk
        $dataSales = Sale::with(['user', 'product'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })->get();

        return view('admin.sales.index', [
            'title' => 'Sales',
            'heading' => 'Sales',
            'description' => $description,
            'dataSales' => $dataSales
        ]);
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();

        return view('admin.sales.create', [
            'title' => 'Create Sale',
            'heading' => 'Create Sale',
            'users' => $users,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'total_harga' => 'required|numeric',
            'jumlah' => 'required|integer',
            'status' => 'required|in:PENDING,COMPLETE',
        ]);

        Sale::create($request->all());

        return redirect()->route('sales.index')->with('success_created', 'Sale berhasil ditambahkan.');
    }

    public function show(Sale $sale)
    {
        return view('admin.sales.show', [
            'title' => 'Detail Sale',
            'heading' => 'Detail Sale',
            'sale' => $sale
        ]);
    }

    public function edit(Sale $sale)
    {
        return view('admin.sales.edit', [
            'title' => 'Edit Sale',
            'description' => 'ini adalah halaman edit data sale',
            'heading' => 'Edit Sale',
            'sale' => $sale
        ]);
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'status' => 'required|in:PENDING,COMPLETE',
        ]);

        $sale->update(['status' => $request->status]);

        return redirect()->route('sales.index')->with('success_updated', 'Sale berhasil diupdate.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success_deleted', 'Sale berhasil dihapus.');
    }

    public function buy(Request $request)
    {
        // Validasi input
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);
    
        // Ambil data cart
        $cart = Cart::findOrFail($request->cart_id);
    
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Hitung total harga (jumlah * harga produk)
        $totalHarga = $cart->quantity * $cart->product->price;
    
        // Validasi apakah stok mencukupi
        $product = $cart->product;
    
        if ($product->stock < $cart->quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk pembelian ini!');
        }
    
        // Buat record baru di tabel sales
        Sale::create([
            'user_id' => $user->id,
            'product_id' => $cart->product_id,
            'total_harga' => $totalHarga,
            'jumlah' => $cart->quantity,
            'status' => 'PENDING', // Status awal pembelian adalah PENDING
        ]);
    
        // Kurangi stok barang
        $product->stock -= $cart->quantity;
        $product->save();
    
        // Hapus item dari cart setelah pembelian berhasil
        $cart->delete();
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success_buy', 'Pembelian berhasil, status PENDING!');
    }

    public function history()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Ambil data penjualan yang sudah diterima (status ACCEPTED) dan sesuai dengan user
        $sales = Sale::where('user_id', $user->id)
                      ->where('status', 'COMPLETE')
                      ->with('product') // Eager load product untuk menghindari N+1 query
                      ->get();
    
        // Debugging output
        if ($sales->isEmpty()) {
            dd('Tidak ada data penjualan yang ditemukan.');
        }
    
        $title = 'history';
        // Kembalikan view dengan data penjualan
        return view('history', compact('sales', 'title'));
    }
    
}

