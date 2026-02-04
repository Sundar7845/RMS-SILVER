<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color',
        'gross_weight',
        'Purity',
        'size',
        'qty',
        'pt_wt',
        '18_avg_weight',
        'gold_wt',
        'dia',
        'cts',
        'chain_length'
    ];
}
