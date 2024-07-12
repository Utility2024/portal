<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Garment extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;
    protected $fillable =['nik','name','department'];

    public function garmentDetails()
    {
        return $this->hasMany(GarmentDetail::class);
    }

    // Di dalam model Garment atau model terkait
    public function getJudgementCountsAttribute()
    {
        $okCount = GarmentDetail::where('garment_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_d1', 'OK')
                            ->orWhere('judgement_d2', 'OK')
                            ->orWhere('judgement_d3', 'OK')
                            ->orWhere('judgement_d4', 'OK');
                    })
                    ->count();

        $ngCount = GarmentDetail::where('garment_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_d1', 'NG')
                            ->orWhere('judgement_d2', 'NG')
                            ->orWhere('judgement_d3', 'NG')
                            ->orWhere('judgement_d4', 'NG');
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
        ->logOnly(['nik','name','department']);
    }

}
