<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
//use OwenIt\Auditing\Auditable;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentGround extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = ['machine_name', 'area', 'location'];

    public function equipmentGroundDetails()
    {
        return $this->hasMany(EquipmentGroundDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = EquipmentGroundDetail::where('equipment_ground_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_ohm', 'OK')
                            ->orWhere('judgement_volts', 'OK');
                    })
                    ->count();

        $ngCount = EquipmentGroundDetail::where('equipment_ground_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_ohm', 'NG')
                            ->orWhere('judgement_volts', 'NG');
                    })
                    ->count();

        return [
            'ok' => $okCount,
            'ng' => $ngCount,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['machine_name', 'area', 'location']);
    }
}
