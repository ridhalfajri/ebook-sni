<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
