<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    public function discounts()
    {
        return $this->hasMany(InsuranceDiscount::class, 'insurance_id');
    }
}
