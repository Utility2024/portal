<?php

namespace App\Models;

use App\Models\IonizerDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ionizer extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;
    protected $fillable =['register_no','area','location'];

    public function ionizerdetails()
    {
        return $this->hasMany(IonizerDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = IonizerDetail::where('ionizer_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_c1', 'OK')
                            ->orWhere('judgement_c2', 'OK')
                            ->orWhere('judgement_c3', 'OK');
                    })
                    ->count();

        $ngCount = IonizerDetail::where('ionizer_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_c1', 'NG')
                            ->orWhere('judgement_c2', 'NG')
                            ->orWhere('judgement_c3', 'NG');
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
        ->logOnly(['register_no','area','location']);
    }
}
