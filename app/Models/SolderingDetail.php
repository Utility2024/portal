<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolderingDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'soldering_id',
        'area',
        'location',
        'e1',
        'judgement',
        'remarks'
    ];

    public function soldering()
    {
        return $this->belongsTo(Soldering::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'soldering_id',
            'area',
            'location',
            'e1',
            'judgement',
            'remarks'
        ]);
    }
}
