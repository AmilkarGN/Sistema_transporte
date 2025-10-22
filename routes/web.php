<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DriverController; 
use App\Http\Controllers\ShipmentController;;
use App\Http\Controllers\ShipmentAssignmentController;
use App\Http\Controllers\TollBoothController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\ClientController;




Route::get('/', function () {
    return view('welcome');
});

    Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', function () {
    return redirect('/dashboard'); // Redirige a /dashboard
})->name('home');



//usuarios combinados
Route::get('/usuarios-combinados', [UserController::class, 'usuariosConductoresRoles'])->name('usuarios.combinados');
//Reporte de usuarios combinados
Route::get('/usuarios-combinados', [UserController::class, 'usuariosConductoresRoles'])->name('usuarios.combinados');
Route::get('/usuarios-combinados/reporte', [UserController::class, 'reporteCombinados'])->name('usuarios.combinados.reporte');


//roles combinados<?php
Route::get('roles-combinados', [RoleController::class, 'combinados'])->name('roles.combinados');
//Reporte de roles combinados
Route::get('roles-combinados/reporte', [RoleController::class, 'reporteCombinados'])->name('roles.combinados.reporte');

//eliminar clientes
Route::get('clients/trashed', [ClientController::class, 'trashed'])->name('clients.trashed');
Route::delete('clients/force-delete/{id}', [ClientController::class, 'forceDelete'])->name('clients.force-delete');

//conductores combinados
Route::get('conductores-combinados', [DriverController::class, 'combinados'])->name('conductores.combinados');
//Reporte de conductores combinados
Route::get('conductores-combinados/reporte', [DriverController::class, 'reporteCombinados'])->name('conductores.combinados.reporte');

//eliminados asignaciones de vehiculos
Route::get('vehicle-assignments/trashed', [VehicleAssignmentController::class, 'trashed'])->name('vehicle-assignments.trashed');
Route::delete('vehicle-assignments/force-delete/{id}', [VehicleAssignmentController::class, 'forceDelete'])->name('vehicle-assignments.force-delete');
// Soft delete routes
Route::get('roles/eliminados', [RoleController::class, 'showDeleted'])->name('roles.eliminados');
Route::patch('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');
// Soft delete driver
Route::get('drivers/eliminados', [DriverController::class, 'showDeleted'])->name('drivers.eliminados');
Route::patch('drivers/{id}/restore', [DriverController::class, 'restore'])->name('drivers.restore');
Route::delete('drivers/{id}/force-delete', [DriverController::class, 'forceDelete'])->name('drivers.forceDelete');
Route::get('vehicle-assignments/trashed', [VehicleAssignmentController::class, 'trashed'])->name('vehicle-assignments.trashed');
Route::delete('vehicle-assignments/force-delete/{id}', [VehicleAssignmentController::class, 'forceDelete'])->name('vehicle-assignments.force-delete');
Route::put('/vehicle-assignments/{id}/restore', [VehicleAssignmentController::class, 'restore'])->name('vehicle-assignments.restore');
Route::get('/vehicles/trashed', [VehicleController::class, 'trashed'])->name('vehicles.trashed');
Route::delete('/vehicles/{id}/force', [VehicleController::class, 'forceDestroy'])->name('vehicles.forceDestroy');
Route::put('/vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
Route::put('/clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');
// Rutas para asignaciones de vehiculos
Route::get('/routes/trashed', [RouteController::class, 'trashed'])->name('routes.trashed');
Route::delete('/routes/{id}/force', [RouteController::class, 'forceDelete'])->name('routes.forceDelete');
Route::put('/routes/{id}/restore', [RouteController::class, 'restore'])->name('routes.restore');
Route::get('/get-vehicle-by-driver/{driver}', [ShipmentAssignmentController::class, 'getVehicleByDriver']);




require __DIR__.'/auth.php';

// Rutas para asignar viajes óptimos
Route::get('/trips/assign-optimal', [TripController::class, 'assignOptimalRoutes'])->name('trips.assign.optimal');
Route::get('/trips/{trip}/assign-optimal', [TripController::class, 'assignOptimalRouteToTrip'])->name('trips.assign.optimal.single');
//reportes
Route::get('/users/report', [UserController::class, 'generateReport'])->name('users.report');
Route::get('/roles/report', [RoleController::class, 'generateReport'])->name('roles.report');
Route::get('/vehicles/report', [VehicleController::class, 'generateReport'])->name('vehicles.report');
Route::get('/routes/report', [RouteController::class, 'generateReport'])->name('routes.report');
Route::get('/drivers/report', [DriverController::class, 'generateReport'])->name('drivers.report');
Route::get('/shipments/report', [ShipmentController::class, 'generateReport'])->name('shipments.report');
Route::get('/shipment-assignments/report', [ShipmentAssignmentController::class, 'generateReport'])->name('shipment-assignments.report');
Route::get('/toll-booths/report', [TollBoothController::class, 'generateReport'])->name('toll-booths.report');
Route::get('/trips/report', [TripController::class, 'generateReport'])->name('trips.report');
Route::get('/bookings/report', [BookingController::class, 'generateReport'])->name('bookings.report');
Route::get('clients/report', [ClientController::class, 'report'])->name('clients.report');
Route::get('vehicle-assignments/report', [VehicleAssignmentController::class, 'report'])->name('vehicle-assignments.report');
Route::get('/routes/report', [RouteController::class, 'report'])->name('routes.report');


Route::get('trips/trashed', [TripController::class, 'trashed'])->name('trips.trashed');
Route::put('trips/{id}/restore', [TripController::class, 'restore'])->name('trips.restore');
Route::delete('trips/{id}/force', [TripController::class, 'forceDelete'])->name('trips.forceDelete');
Route::resource('trips', TripController::class);


Route::get('bookings/trashed', [BookingController::class, 'trashed'])->name('bookings.trashed');
Route::put('bookings/{id}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
Route::delete('bookings/{id}/force', [BookingController::class, 'forceDelete'])->name('bookings.forceDelete');

Route::get('toll-booths/trashed', [TollBoothController::class, 'trashed'])->name('toll-booths.trashed');
Route::put('toll-booths/{id}/restore', [TollBoothController::class, 'restore'])->name('toll-booths.restore');
Route::delete('toll-booths/{id}/force', [TollBoothController::class, 'forceDelete'])->name('toll-booths.forceDelete');
Route::resource('toll-booths', TollBoothController::class);

// RUTAS PERSONALIZADAS PRIMERO
Route::get('/shipments/trashed', [ShipmentController::class, 'trashed'])->name('shipments.trashed');
Route::put('/shipments/{id}/restore', [ShipmentController::class, 'restore'])->name('shipments.restore');
Route::delete('/shipments/{id}/force', [ShipmentController::class, 'forceDelete'])->name('shipments.forceDelete');
// LUEGO EL RESOURCE
Route::resource('shipments', ShipmentController::class);

// Rutas personalizadas para ShipmentAssignmentController
Route::get('shipment-assignments/trashed', [ShipmentAssignmentController::class, 'trashed'])->name('shipment-assignments.trashed');
Route::put('shipment-assignments/{id}/restore', [ShipmentAssignmentController::class, 'restore'])->name('shipment-assignments.restore');
Route::delete('shipment-assignments/{id}/force', [ShipmentAssignmentController::class, 'forceDelete'])->name('shipment-assignments.forceDelete');

// Soft delete routes
Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::get('/users/eliminados', [UserController::class, 'showDeleted'])->name('users.deleted');
Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

// Rutas específicas para Bookings ANTES de Route::resource
Route::get('booking/calendar', [BookingController::class, 'calendar'])->name('booking.calendar');

// Ruta para obtener los datos del calendario (eventos)
Route::get('bookings/calendar-data', [BookingController::class, 'calendarData'])->name('bookings.calendar-data');


// CRUD routes
Route::resource('users', UserController::class);
Route::resource('vehicles', VehicleController::class);
Route::resource('routes', RouteController::class);
Route::resource('drivers', DriverController::class);
Route::resource('shipments', ShipmentController::class);
Route::resource('shipment-assignments', ShipmentAssignmentController::class);
Route::resource('toll-booths', TollBoothController::class);
Route::resource('trips', TripController::class);
Route::resource('bookings', BookingController::class); // Esta debe ir después de las rutas específicas de bookings
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('vehicle-assignments', VehicleAssignmentController::class);
Route::resource('clients', ClientController::class);

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('bookings/comprobante/{id}', [App\Http\Controllers\BookingController::class, 'downloadComprobante'])->name('bookings.downloadComprobante');
Route::get('bookings/regenerar-comprobante/{id}', [App\Http\Controllers\BookingController::class, 'regenerateComprobante'])->name('bookings.regenerateComprobante');
Route::middleware(['auth'])->group(function () {
    Route::get('perfil', [UserController::class, 'perfil'])->name('user.perfil');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
});
