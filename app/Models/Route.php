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
 * Class Route
 * 
 * @property int $id
 * @property string $name
 * @property string $origin
 * @property string $destination
 * @property float $distance_km
 * @property float $estimated_time_hours
 * @property int|null $toll_booths
 * @property float|null $estimated_toll_cost
 * @property string|null $status
 * @property string|null $difficulty
 * @property string|null $details
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * @property int|null $risk_points
 * @property Carbon|null $last_update
 * 
 * @property Collection|Booking[] $bookings
 * @property Collection|Trip[] $trips
 *
 * @package App\Models
 */
class Route extends Model
{
	use SoftDeletes;
	protected $table = 'routes';

	protected $casts = [
		'distance_km' => 'float',
		'estimated_time_hours' => 'float',
		'toll_booths' => 'int',
		'estimated_toll_cost' => 'float',
		'risk_points' => 'int',
		'last_update' => 'datetime'
	];


protected $fillable = [
    'name', 'origin', 'origen_lat', 'origen_lng', 'destination', 'destino_lat', 'destino_lng',
    'distance_km', 'estimated_time_hours', 'toll_booths', 'estimated_toll_cost',
    'status', 'difficulty', 'details', 'risk_points', 'last_update'
];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function toll_booths()
	{
		return $this->hasMany(TollBooth::class);
	}

	public function trips()
	{
		return $this->hasMany(Trip::class);
	}
}
