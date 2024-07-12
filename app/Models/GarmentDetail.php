<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GarmentDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'garment_id',
        'name',
        'd1',
        'd1_scientific',
        'judgement_d1',
        'd2',
        'd2_scientific',
        'judgement_d2',
        'd3',
        'd3_scientific',
        'judgement_d3',
        'd4',
        'd4_scientific',
        'judgement_d4',
        'remarks',
    ];

    public function garment()
    {
        return $this->belongsTo(Garment::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'garment_id',
            'name',
            'd1',
            'd1_scientific',
            'judgement_d1',
            'd2',
            'd2_scientific',
            'judgement_d2',
            'd3',
            'd3_scientific',
            'judgement_d3',
            'd4',
            'd4_scientific',
            'judgement_d4',
            'remarks'
        ]);
    }
}
