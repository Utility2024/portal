<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlooringDetail extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;

    protected $fillable = ['flooring_id', 'area', 'location', 'b1', 'b1_scientific', 'judgement', 'remarks'];

    public function flooring()
    {
        return $this->belongsTo(Flooring::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['flooring_id', 'area', 'location', 'b1', 'b1_scientific', 'judgement', 'remarks']);
    }
}