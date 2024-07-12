<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GloveDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity,  \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'glove_id',
        'description',
        'delivery',
        'c1',
        'c1_scientific',
        'judgement',
        'remarks',
    ];

    /**
     * Get the glove that owns the detail.
     */
    public function glove()
    {
        return $this->belongsTo(Glove::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'glove_id',
            'description',
            'delivery',
            'c1',
            'c1_scientific',
            'judgement',
            'remarks'
        ]);
    }
}
