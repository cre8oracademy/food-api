<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $casts = [
        'alergic_to' => 'array'
    ];
    protected $table = 'product_category_item';
}
