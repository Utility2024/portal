<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sap_code',
        'description',
        'type',
        'qty_first',
        'in',
        'out',
        'last_stock',
        'minimum_stock',
        'unit',
        'information',
        'price',
        'total_price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'qty_first' => 'integer',
        'in' => 'integer',
        'out' => 'integer',
        'last_stock' => 'integer',
        'minimum_stock' => 'integer',
        'unit',
        'information',
        'price',
        'total_price'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
