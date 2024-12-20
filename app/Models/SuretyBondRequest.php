<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuretyBondRequest extends Model
{
    use HasFactory;

    protected $table = 'srb_request';

    protected $guarded = ['id'];

    protected $with = ['suretyBond'];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }

    public function requestedTo()
    {
        return $this->belongsTo(User::class, 'requested_to', 'id');
    }

    public function suretyBond()
    {
        return $this->hasOne(SuretyBond::class, 'id', 'surety_bond_id');
    }
}
