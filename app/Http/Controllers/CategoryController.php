<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $description = 'Tabel categories digunakan untuk menyimpan informasi mengenai kategori. Setiap kategori memiliki data yang unik dan teridentifikasi dengan id berupa ULID.';

        // Ambil input search dari request
        $search = $request->input('search');

        // Query untuk mencari kategori berdasarkan nama atau deskripsi
        $dataCategories = Category::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })->get();

        return view('admin.categories.index', [
            'title' => 'Categories',
            'heading' => 'Categories',
            'description' => $description,
            'dataCategories' => $dataCategories
        ]);
    }

    public function create()
    {
        return view('admin.categories.create', [
            'title' => 'Add Category',
            'heading' => 'Add Category',
            'description' => 'form tambah data category'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect('/admin/categories')->with('success_created', 'Category created successfully!');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.show', [
            'title' => 'Category Detail',
            'heading' => 'Category Detail',
            'category' => $category
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', [
            'title' => 'Edit Category',
            'heading' => 'Edit Category',
            'description' => 'form edit data category',
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect('/admin/categories')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/admin/categories')->with('success_deleted', 'Category deleted successfully!');
    }
}
