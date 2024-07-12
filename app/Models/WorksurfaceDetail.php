<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorksurfaceDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity,\OwenIt\Auditing\Auditable;

    // Tentukan atribut yang bisa diisi secara massal
    protected $fillable = [
        'worksurface_id',
        'area',
        'location',
        'item',
        'a1',
        'a1_scientific',
        'judgement_a1',
        'a2',
        'judgement_a2',
        'remarks',
    ];

    // Relasi many-to-one dengan Worksurface
    public function worksurface()
    {
        return $this->belongsTo(Worksurface::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'worksurface_id',
            'area',
            'location',
            'item',
            'a1',
            'a1_scientific',
            'judgement_a1',
            'a2',
            'judgement_a2',
            'remarks'
        ]);
    }
}
