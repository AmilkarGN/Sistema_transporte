<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VehicleAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = ['driver_id', 'vehicle_id', 'assigned_at'];

    public function driver()
    {
        return $this->belongsTo(\App\Models\Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Vehicle::class);
    }
    
    public function vehicleAssignments()
    {

        return $this->hasMany(\App\Models\VehicleAssignment::class);
    }


}