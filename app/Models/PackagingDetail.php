<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackagingDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;
    protected $fillable = ['packaging_id', 'status', 'item', 'f1', 'f1_scientific', 'judgement', 'remarks'];

    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['packaging_id', 'status', 'item', 'f1', 'f1_scientific', 'judgement', 'remarks']);
    }
}
