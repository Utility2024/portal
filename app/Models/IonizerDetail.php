<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IonizerDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ionizer_id',
        'area',
        'location',
        'pm_1',
        'pm_2',
        'pm_3',
        'c1',
        'judgement_c1',
        'c2',
        'judgement_c2',
        'c3',
        'judgement_c3',
        'remarks'
    ];

    /**
     * Get the ionizer that owns the ionizer detail.
     */
    public function ionizer()
    {
        return $this->belongsTo(Ionizer::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'ionizer_id',
            'area',
            'location',
            'pm_1',
            'pm_2',
            'pm_3',
            'c1',
            'judgement_c1',
            'c2',
            'judgement_c2',
            'c3',
            'judgement_c3',
            'remarks'
        ]);
    }
}
