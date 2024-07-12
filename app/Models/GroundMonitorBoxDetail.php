<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundMonitorBoxDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity,\OwenIt\Auditing\Auditable;

    protected $fillable = [
        'ground_monitor_box_id',
        'area',
        'location',
        'g1',
        'g2',
        'remarks',
    ];

    public function groundMonitorBox()
    {
        return $this->belongsTo(GroundMonitorBox::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'ground_monitor_box_id',
            'area',
            'location',
            'g1',
            'g2',
            'remarks'
        ]);
    }
}
