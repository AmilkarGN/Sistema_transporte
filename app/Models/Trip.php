<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Trip
 * 
 * @property int $id
 * @property int $route_id
 * @property int $vehicle_id
 * @property int $driver_id
 * @property Carbon $departure_date
 * @property Carbon $estimated_arrival
 * @property Carbon|null $actual_arrival
 * @property string|null $status
 * @property float|null $estimated_total_cost
 * @property float|null $actual_total_cost
 * @property int|null $initial_mileage
 * @property int|null $final_mileage
 * @property string|null $notes
 * @property float|null $time_deviation
 * @property int|null $route_score
 * @property string|null $delay_reason
 * @property int|null $problem_segment_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string|null $deleted_at
 * 
 * @property Route $route
 * @property Vehicle $vehicle
 * @property Driver $driver
 * @property Collection|Booking[] $bookings
 * @property Collection|ShipmentAssignment[] $shipment_assignments
 *
 * @package App\Models
 */
class Trip extends Model
{
	use SoftDeletes;
	protected $table = 'trips';

	protected $casts = [
		'route_id' => 'int',
		'vehicle_id' => 'int',
		'driver_id' => 'int',
		'departure_date' => 'datetime',
		'estimated_arrival' => 'datetime',
		'actual_arrival' => 'datetime',
		'estimated_total_cost' => 'float',
		'actual_total_cost' => 'float',
		'initial_mileage' => 'int',
		'final_mileage' => 'int',
		'time_deviation' => 'float',
		'route_score' => 'int',
		'problem_segment_id' => 'int'
	];

	protected $fillable = [
		'route_id',
		'vehicle_id',
		'driver_id',
		'departure_date',
		'estimated_arrival',
		'actual_arrival',
		'status',
		'estimated_total_cost',
		'actual_total_cost',
		'initial_mileage',
		'final_mileage',
		'notes',
		'time_deviation',
		'route_score',
		'delay_reason',
		'problem_segment_id'
	];

	public function route()
	{
		return $this->belongsTo(\App\Models\Route::class);
	}
	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	public function driver()
	{
		return $this->belongsTo(Driver::class);
	}

	public function bookings()
	{
		return $this->hasMany(Booking::class, 'assigned_trip_id');
	}

	public function shipment_assignments()
	{
		return $this->hasMany(ShipmentAssignment::class);
	}
}
