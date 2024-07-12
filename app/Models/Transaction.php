<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'material_id',
        'description_id',
        'type',
        'price',
        'transaction_type',
        'qty',
        'total_price',
        'pic',
        'keterangan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'material_id',
        'description_id',
        'type',
        'price',
        'transaction_type',
        'date',
        'qty',
        'total_price',
        'pic',
        'keterangan'
    ];

    /**
     * Get the material that owns the transaction.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
