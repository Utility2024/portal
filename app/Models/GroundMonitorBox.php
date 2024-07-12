<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundMonitorBox extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;
    
    protected $fillable =['register_no','area','location'];

    public function groundMonitorBoxDetails()
    {
        return $this->hasMany(GroundMonitorBoxDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $yesCount = GroundMonitorBoxDetail::where('ground_monitor_box_id', $this->id)
                    ->where(function($query) {
                        $query->where('g1', 'YES')
                            ->orWhere('g2', 'YES');
                    })
                    ->count();

        $noCount = GroundMonitorBoxDetail::where('ground_monitor_box_id', $this->id)
                    ->where(function($query) {
                        $query->where('g1', 'NO')
                            ->orWhere('g2', 'NO');
                    })
                    ->count();

        return [
            'yes' => $yesCount,
            'no' => $noCount,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no','area','location']);
    }
}
