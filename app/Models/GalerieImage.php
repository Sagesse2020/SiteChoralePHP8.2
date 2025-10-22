<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalerieImage extends Model
{
      use HasFactory;

    protected $fillable = ['galerie_id', 'image', 'description'];

    public function galerie()
    {
        return $this->belongsTo(Galerie::class);
    }
}
