<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $description = 'Tabel products digunakan untuk menyimpan informasi mengenai product. Setiap product memiliki data yang unik dan teridentifikasi dengan id berupa ULID.';

        // Ambil input search dari request
        $search = $request->input('search');

        // Query untuk mencari kategori berdasarkan nama atau deskripsi
        $dataProducts = Product::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })->get();

        return view('admin.products.index', [
            'title' => 'products',
            'heading' => 'Product',
            'description' => $description,
            'dataProducts' => $dataProducts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'products' ;
        $heading = 'Products' ;
        $description = 'form tambah data products' ;
        $categories = Category::all(); // Untuk menampilkan kategori pada form create
        return view('admin.products.create', compact('categories','title','heading','description'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Upload file foto
        $path = $request->file('foto')->store('folder_images');

        // Simpan data produk ke database
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'foto' => $path,
            'category_id' => $request->input('category_id')
        ]);

        return redirect('/admin/products')->with('success_created', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

        public function edit(Product $product)
        {
            $title = 'products' ;
            $heading = 'Products' ;
            $description = 'form tambah data products' ;
            $categories = Category::all(); // Untuk menampilkan kategori pada form create
            return view('admin.products.edit', compact('product','categories','title','heading','description'));
        }
        
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Jika ada foto baru, upload dan hapus foto lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('folder_images');
            $product->foto = $path;
        }

        // Update data produk
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'),
            'foto' => $product->foto // tetap pakai yang ada jika tidak ada update
        ]);

        return redirect('/admin/products')->with('success_updated', 'Product updated successfully.');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/admin/products')->with('success_deleted', 'Product deleted successfully.');
    }
}
