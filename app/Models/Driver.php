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
 * Class Driver
 * 
 * @property int $id
 * @property int $user_id
 * @property string $license_number
 * @property Carbon $license_expiration
 * @property string|null $license_type
 * @property string|null $status
 * @property int|null $monthly_driving_hours
 * @property float|null $safety_score
 * @property Carbon|null $last_evaluation
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 * @property Collection|Trip[] $trips
 * @property Collection|Vehicle[] $vehicles
 *
 * @package App\Models
 */
class Driver extends Model
{
	use SoftDeletes;
	protected $table = 'drivers';

	protected $casts = [
		'user_id' => 'int',
		'license_expiration' => 'datetime',
		'monthly_driving_hours' => 'int',
		'safety_score' => 'float',
		'last_evaluation' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'license_number',
		'license_expiration',
		'license_type',
		'status',
		'monthly_driving_hours',
		'safety_score',
		'last_evaluation'
	];


	public function user()
	{
    	return $this->belongsTo(User::class, 'user_id');
	}


	public function trips()
	{
   	 return $this->hasMany(\App\Models\Trip::class, 'driver_id');
	}

	public function vehicles()
	{
		return $this->hasMany(Vehicle::class);
	}

	public function vehicleAssignments()
	{
    	return $this->hasMany(\App\Models\VehicleAssignment::class);
	}
}
