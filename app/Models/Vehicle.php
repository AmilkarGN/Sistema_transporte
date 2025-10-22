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
 * Class Vehicle
 * 
 * @property int $id
 * @property string $license_plate
 * @property string $brand
 * @property string $model
 * @property int $year
 * @property float $load_capacity
 * @property float|null $load_volume
 * @property string $type
 * @property string|null $status
 * @property int|null $driver_id
 * @property Carbon|null $last_maintenance_date
 * @property Carbon|null $next_maintenance_date
 * @property bool|null $active_insurance
 * @property string|null $insurance_policy
 * @property float|null $average_speed
 * @property float|null $historical_performance
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string|null $deleted_at
 * 
 * @property Driver|null $driver
 * @property Collection|Trip[] $trips
 *
 * @package App\Models
 */
class Vehicle extends Model
{
	use SoftDeletes;
	protected $table = 'vehicles';

	protected $casts = [
		'year' => 'int',
		'load_capacity' => 'float',
		'load_volume' => 'float',
		'driver_id' => 'int',
		'last_maintenance_date' => 'datetime',
		'next_maintenance_date' => 'datetime',
		'active_insurance' => 'bool',
		'average_speed' => 'float',
		'historical_performance' => 'float'
	];

	protected $fillable = [
		'license_plate',
		'brand',
		'model',
		'year',
		'load_capacity',
		'load_volume',
		'type',
		'status',
		'last_maintenance_date',
		'next_maintenance_date',
		'active_insurance',
		'insurance_policy',
		'average_speed',
		'historical_performance'
	];

	// Elimina/comenta la relación driver() y usa la relación con VehicleAssignment
	// public function driver()
	// {
	//     return $this->belongsTo(Driver::class);
	// }

	// Relación muchos a muchos a través de la tabla de asignaciones de vehículos
	public function drivers()
	{
		return $this->belongsToMany(
			\App\Models\Driver::class,
			'vehicle_assignments', // nombre de la tabla pivote
			'vehicle_id', // clave foránea en la tabla pivote hacia Vehicle
			'driver_id'   // clave foránea en la tabla pivote hacia Driver
		);
	}

	public function trips()
	{
		return $this->hasMany(Trip::class);
	}

	public function vehicleAssignments()
	{
		return $this->hasMany(\App\Models\VehicleAssignment::class);
	}
}
