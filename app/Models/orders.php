<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $table = "order_t";
    public function getDetails()
    {
        return $this->hasOne('App\Models\orderDetails');

    }//end
}
