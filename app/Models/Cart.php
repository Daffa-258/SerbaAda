<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Cart extends Model
{
    use HasFactory,HasUlids;
    protected $guarded = [];

      // Relasi ke model User
      public function user()
      {
          return $this->belongsTo(User::class);
      }
  
      // Relasi ke model Product
      public function product()
      {
          return $this->belongsTo(Product::class);
      }
}
