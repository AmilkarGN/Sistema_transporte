<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Shipment
 * 
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property float $weight_kg
 * @property float $volume_m3
 * @property string|null $description
 * @property Carbon $request_date
 * @property Carbon|null $required_date
 * @property string|null $status
 * @property string $origin
 * @property string $destination
 * @property Carbon|null $estimated_delivery_date
 * @property Carbon|null $actual_delivery_date
 * @property string|null $priority
 * @property bool|null $requires_refrigeration
 * @property string|null $special_instructions
 * 
 * @property User $user
 * @property Collection|ShipmentAssignment[] $shipment_assignments
 *
 * @package App\Models
 */
class Shipment extends Model
{
	    use HasFactory;

	    use SoftDeletes;
	protected $table = 'shipments';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'weight_kg' => 'float',
		'volume_m3' => 'float',
		'request_date' => 'datetime',
		'required_date' => 'datetime',
		'estimated_delivery_date' => 'datetime',
		'actual_delivery_date' => 'datetime',
		'requires_refrigeration' => 'bool'
	];

	protected $fillable = [
        'client_id',
        'type',
        'weight_kg',
        'volume_m3',
        'description',
        'request_date',
        'required_date',
        'status',
        'origin',
        'origin_lat', // Asegúrate de que estos también estén fillable
        'origin_lng', // Asegúrate de que estos también estén fillable
        'destination',
        'destination_lat', // Asegúrate de que estos también estén fillable
        'destination_lng', // Asegúrate de que estos también estén fillable
        'estimated_delivery_date',
        'actual_delivery_date',
        'priority',
        'special_instructions',
        'user_id', // ¡Asegúrate de que user_id esté aquí!
    ];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function shipment_assignments()
	{
		return $this->hasMany(ShipmentAssignment::class);
	}

public function client()
{
    return $this->belongsTo(\App\Models\Client::class, 'client_id');
}
public function trip()
{
    return $this->belongsTo(\App\Models\Trip::class, 'trip_id');
}
public function route()
{
    return $this->belongsTo(\App\Models\Route::class, 'route_id');
}
}