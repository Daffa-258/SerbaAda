<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $description = 'Tabel users digunakan untuk menyimpan informasi mengenai pengguna sistem. Setiap pengguna memiliki data yang unik dan teridentifikasi dengan id berupa ULID. Tabel ini menyimpan informasi penting terkait pengguna, termasuk detail identitas, kontak, dan data login';
        $search = $request->input('search');

        // Query untuk mencari users berdasarkan nama atau email
        $dataUsers = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->get();
        

        return view('admin.users',[
            'title' => 'users',
            'heading' => 'Users',
            'description' => $description,
            'dataUsers' => $dataUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{

    return view('register',[
        'title' => 'register'
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi data input
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8|confirmed', // Menambahkan validasi confirmed
    ]);

    // Simpan data user hanya dengan name, email, dan password
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password), // Enkripsi password
    ]);

    return redirect('/admin/users/create')->with('success_create', 'User created successfully.');}


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.userDetail',[
            'title' => 'users',
            'heading' => 'detail profile : '.$user->name,
            'description' => "Halaman yang menampilkan detail informasi dari user.",
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('profile',[
            'title' => 'profile',
            'userId' => auth()->user()->id,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi data input (email tidak diikutsertakan karena tidak diubah)
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'nullable|string|min:8',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Update atribut user kecuali email
        $user->name = $validated['name'];
        $user->alamat = $validated['alamat'];
        $user->no_hp = $validated['no_hp'];
    
        // Cek jika password diisi dan update
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
    
        // Menangani upload file foto
        if ($request->hasFile('foto')) {
           // Hapus gambar lama jika ada
            if ($user->foto && file_exists(storage_path('app/public/' . $user->foto))) {
                unlink(storage_path('app/public/' . $user->foto));
            }
    
            // Simpan gambar baru
            $imagePath = $request->file('foto')->store('folder_images');
    
            // Update field foto pada user
            $user->foto = $imagePath;
        }
    
        // Simpan data user yang sudah diupdate
        $user->save();
    
        // Redirect dengan pesan sukses
        return redirect('/admin/users/' . $user->id . '/edit')->with('success_update', 'User berhasil diupdate.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    
        return redirect()->back()->with('success_delete', 'User deleted successfully.');
    }
}
