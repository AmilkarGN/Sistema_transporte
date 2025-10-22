<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'shipment_assignments';

    protected $fillable = [
        // ...otros campos...
        'shipment_id',
        // ...otros campos...
    ];

    // ... (otros atributos y métodos)

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    

    // NUEVAS RELACIONES

    /**
     * Relación con el conductor asignado.
     */
    public function driver() { return $this->belongsTo(Driver::class, 'driver_id'); }
public function vehicle() { return $this->belongsTo(Vehicle::class, 'vehicle_id'); }
public function route() { return $this->belongsTo(Route::class, 'route_id'); }
        public function shipment() { return $this->belongsTo(Shipment::class, 'shipment_id'); }
}

