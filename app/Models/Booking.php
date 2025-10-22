<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking
 * 
 * @property int $id
 * @property int $user_id
 * @property int $route_id
 * @property Carbon $request_date
 * @property Carbon $estimated_trip_date
 * @property string|null $status
 * @property string $estimated_shipment_type
 * @property float $estimated_weight
 * @property float|null $estimated_volume
 * @property string|null $priority
 * @property string|null $notes
 * @property int|null $assigned_trip_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 * @property Route $route
 * @property Trip|null $trip
 *
 * @package App\Models
 */
class Booking extends Model
{
	use SoftDeletes;
	protected $table = 'bookings';

	protected $casts = [
		'user_id' => 'int',
		'route_id' => 'int',
		'request_date' => 'datetime',
		'estimated_trip_date' => 'datetime',
		'estimated_weight' => 'float',
		'estimated_volume' => 'float',
		'assigned_trip_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'route_id',
		'request_date',
		'estimated_trip_date',
		'status',
		'estimated_shipment_type',
		'estimated_weight',
		'estimated_volume',
		'priority',
		'notes',
		'assigned_trip_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function route()
	{
		return $this->belongsTo(Route::class);
	}

	public function trip()
	{
		return $this->belongsTo(Trip::class, 'assigned_trip_id');
	}
}
