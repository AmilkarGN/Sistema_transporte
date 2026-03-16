<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models; // <-- Corregido a minúsculas
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;



/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Booking[] $bookings
 * @property Collection|Driver[] $drivers
 * @property Collection|ModelHasRole[] $model_has_roles
 * @property Collection|Session[] $sessions
 * @property Collection|Shipment[] $shipments
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable, HasFactory;
	
	use SoftDeletes;
	use HasRoles;

	protected $table = 'users';

	protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
	'password',
	'two_factor_code',
	'two_factor_expires_at' // <-- Agregar estos

];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

		public function driver()
	{
		return $this->hasOne(\App\Models\Driver::class, 'driver_id');
	}

	public function model_has_roles()
	{
		return $this->hasMany(ModelHasRole::class, 'model_id');
	}

	public function sessions()
	{
		return $this->hasMany(Session::class);
	}

	public function shipments()
	{
		return $this->hasMany(Shipment::class);
	}
	public function deletedBy()
	{
		return $this->belongsTo(User::class, 'deleted_by');
	}
	public function safeDevices()
{
    return $this->hasMany(UserDevice::class);
}
}

