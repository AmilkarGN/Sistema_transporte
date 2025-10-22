<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TollBooth
 * 
 * @property int $id
 * @property string $name
 * @property string $location
 * @property int $route_id
 * @property float $heavy_vehicle_cost
 * @property string|null $operation_hours
 * @property float|null $latitude
 * @property float|null $longitude
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string|null $deleted_at
 * 
 * @property Route $route
 *
 * @package App\Models
 */
class TollBooth extends Model
{
	use SoftDeletes;
	protected $table = 'toll_booths';

	protected $casts = [
		'route_id' => 'int',
		'heavy_vehicle_cost' => 'float',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $fillable = [
		'name',
		'location',
		'route_id',
		'heavy_vehicle_cost',
		'operation_hours',
		'latitude',
		'longitude'
	];

	public function route()
	{
		return $this->belongsTo(Route::class);
	}
}
