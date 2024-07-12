<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Glove extends Model implements Auditable
{
    use HasFactory, LogsActivity,  \OwenIt\Auditing\Auditable;
    protected $fillable =['sap_code','description','delivery'];

    public function gloveDetails()
    {
        return $this->hasMany(GloveDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = GloveDetail::where('glove_id', $this->id)->where('judgement', 'OK')->count();
        $ngCount = GloveDetail::where('glove_id', $this->id)->where('judgement', 'NG')->count();

        return [
            'ok' => $okCount,
            'ng' => $ngCount
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['sap_code','description','delivery']);
    }
}
