<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Product extends Model
{
    use HasFactory,HasUlids;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

        // Relasi ke tabel Cart (Pivot Table)
        public function carts()
        {
            return $this->hasMany(Cart::class);
        }
    
        // Relasi ke pengguna melalui Cart
        public function users()
        {
            return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id')
                        ->withPivot('quantity') // Menyertakan kolom quantity dari pivot
                        ->withTimestamps(); // Menyertakan timestamps dari tabel pivot
        }

 
}
