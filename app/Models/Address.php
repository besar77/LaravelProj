<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function deliveryArea() //nese se bojm emrin e funskionit njejt si modeli , athere duhet emrin e foreignkey me ja qu
    {
        return $this->belongsTo(DeliveryArea::class);
    }
}
