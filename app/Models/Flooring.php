<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flooring extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = ['register_no', 'area', 'location'];

    public function flooringDetails()
    {
        return $this->hasMany(FlooringDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = FlooringDetail::where('flooring_id', $this->id)->where('judgement', 'OK')->count();
        $ngCount = FlooringDetail::where('flooring_id', $this->id)->where('judgement', 'NG')->count();

        return [
            'ok' => $okCount,
            'ng' => $ngCount
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no', 'area', 'location']);
    }
}
