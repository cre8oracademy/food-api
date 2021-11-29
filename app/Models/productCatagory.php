<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productCatagory extends Model
{
    use HasFactory;
    protected $table = 'product_category';
    public function setProfiles()
    {
        return $this->hasMany(products::class);

    }//end
}
