<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transections extends Model
{
    use HasFactory;
    protected $casts = [
        'paid'=>'boolean',
        'unpaid'=>'boolean',
        'cancle'=>'boolean',
        'sales'=>'integer',
    ];
}
