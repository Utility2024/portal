<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EightyNine\Approvals\Models\ApprovableModel;

class EquipmentGroundDetail extends ApprovableModel implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'equipment_ground_id',
        'area',
        'location',
        'measure_results_ohm',
        'judgement_ohm',
        'measure_results_volts',
        'judgement_volts',
        'remarks',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['equipment_ground_id', 'area', 'location', 'measure_results_ohm', 'judgement_ohm','measure_results_volts', 'judgement_volts', 'remarks']);
    }

    public function equipmentGround()
    {
        return $this->belongsTo(EquipmentGround::class);
    }

}
