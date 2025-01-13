<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuretyBond extends Model
{
    use HasFactory;

    protected $table = 'surety_bond';

    protected $guarded = ['id'];

    protected $with = ['progres'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->hasMany(SuretyBondRequest::class, 'surety_bond_id', 'id');
    }

    public function progres()
    {
        return $this->hasMany(SuretyBondProgres::class, 'surety_bond_id', 'id');
    }

    public function getStatusHtml()
    {
        switch ($this->status) {
            case 'Selesai':
                $textColor = 'text-success';
                break;

            case 'Proses' : case 'Diterima' :
                $textColor = 'text-orange';
                break;
                
            default:
                $textColor = 'text-danger';
                break;
        }
        return  '<span class="'.$textColor.' font-weight-bold">'.$this->status.'</span>';
    }
}
