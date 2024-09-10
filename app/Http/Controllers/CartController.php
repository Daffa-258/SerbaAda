<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Uid\Ulid;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->input('product_id');
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        // Cek apakah produk sudah ada di cart user
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Jika belum ada, buat entri baru di cart
            Cart::create([
                'id' => Ulid::generate(),
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1, // Set quantity menjadi 1
            ]);
        }

        return redirect()->back()->with('success_addtocart', 'Product added to cart successfully!');
    }

    // Tampilkan cart
    public function index()
    {
        $userId = auth()->user()->id; // Mengambil user yang sedang login
        $carts = Cart::where('user_id', $userId)->with('product')->get(); // Mengambil data cart sesuai user
        $title = 'carts' ;
        return view('cart', compact('carts','title'));
    }

    // Hapus item dari cart
    public function remove(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id); // Mencari data cart berdasarkan ID
        $cart->delete(); // Menghapus data cart

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari cart.');
    }

    // Update quantity
    public function update(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id); // Mencari data cart berdasarkan ID
        $cart->quantity = $request->quantity; // Update quantity sesuai input
        $cart->save(); // Simpan perubahan

        return redirect()->route('cart.index')->with('success', 'Quantity berhasil diupdate.');
    }
}

