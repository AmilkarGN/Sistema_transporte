@php
    $licenseTypes = [
        'A' => 'Tipo A',
        'B' => 'Tipo B',
        'C' => 'Tipo C',
        'D' => 'Tipo D',
        'E' => 'Tipo E',
        // Agrega otros tipos de licencia si es necesario
    ];

    $statuses = [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        'on_leave' => 'De Vacaciones',
        'suspended' => 'Suspendido',
        // Agrega otros estados si es necesario
    ];

    // Opciones para el puntaje de seguridad del 1 al 5
    $safetyScores = range(1, 5);
@endphp

{{-- El formulario ahora usa las variables $url y $method pasadas desde el controlador --}}
<form method="POST" action="{{ $url }}" role="form" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PATCH' || $method === 'PUT')
        {{ method_field($method) }}
    @endif

    {{-- Contenido existente del formulario --}}
    <div class="row">
        <div class="col-md-12">

            <div class="row">
        <div class="col-md-12">
            {{-- Este bloque se muestra al crear --}}
            @if(!isset($driver) || !$driver->exists) {{-- Usamos $driver->exists para diferenciar crear/editar --}}
                <div class="form-group">
                    <label for="user_id" class="form-label">Usuario Conductor</label>
                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="user_id" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('user_id', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
                </div>
            @else
                {{-- Este bloque se muestra al editar --}}
                <div class="form-group">
                    <label class="form-label">Usuario Conductor</label>
                    <input type="text" class="form-control" value="{{ optional($driver->user)->name }} ({{ optional($driver->user)->email }})" disabled>
                    <input type="hidden" name="user_id" value="{{ $driver->user_id }}">
                </div>
            @endif


            @if(isset($driver) && $driver->exists) {{-- El campo user_name solo al editar --}}
                <div class="form-group">
                    <label for="user_name" class="form-label">Nombre de Usuario</label>
                    <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                           value="{{ old('user_name', optional($driver->user)->name) }}" id="user_name" placeholder="Nombre de Usuario">
                {!! $errors->first('user_name', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
                </div>
            @endif

            <!-- ...el resto de tus campos... -->

            <div class="form-group">
                <label for="license_number" class="form-label">Número de Licencia</label>
                <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" value="{{ old('license_number', $driver?->license_number) }}" id="license_number" placeholder="Número de Licencia">
                {!! $errors->first('license_number', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>
            <div class="form-group">
                <label for="license_expiration" class="form-label">Vencimiento de Licencia</label>
                <input type="date" name="license_expiration" class="form-control @error('license_expiration') is-invalid @enderror" value="{{ old('license_expiration', $driver?->license_expiration) }}" id="license_expiration" placeholder="Vencimiento de Licencia">
                {!! $errors->first('license_expiration', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>

            {{-- Campo Tipo de Licencia como Selector --}}
            <div class="form-group">
                <label for="license_type" class="form-label">Tipo de Licencia</label>
                <select name="license_type" class="form-control @error('license_type') is-invalid @enderror" id="license_type">
                    <option value="">Seleccione un tipo</option>
                    @foreach($licenseTypes as $value => $label)
                        <option value="{{ $value }}" {{ old('license_type', $driver?->license_type) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('license_type', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>

            {{-- Campo Estado como Selector --}}
            <div class="form-group">
                <label for="status" class="form-label">Estado</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                    <option value="">Seleccione un estado</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $driver?->status) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('status', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group">
                <label for="monthly_driving_hours" class="form-label">Horas de Conducción Mensuales</label>
                <input type="text" name="monthly_driving_hours" class="form-control @error('monthly_driving_hours') is-invalid @enderror" value="{{ old('monthly_driving_hours', $driver?->monthly_driving_hours) }}" id="monthly_driving_hours" placeholder="Horas de Conducción Mensuales">
                {!! $errors->first('monthly_driving_hours', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>

            {{-- Campo Puntaje de Seguridad como Selector --}}
            <div class="form-group">
                <label for="safety_score" class="form-label">Puntaje de Seguridad</label>
                <select name="safety_score" class="form-control @error('safety_score') is-invalid @enderror" id="safety_score">
                    <option value="">Seleccione un puntaje  (5 alta, 1 baja)</option>
                    @foreach($safetyScores as $score)
                        <option value="{{ $score }}" {{ old('safety_score', $driver?->safety_score) == $score ? 'selected' : '' }}>
                            {{ $score }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('safety_score', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group">
        <label for="last_evaluation" class="form-label">Última Evaluación</label>
        <input type="date" name="last_evaluation" class="form-control @error('last_evaluation') is-invalid @enderror" value="{{ old('last_evaluation', $driver?->last_evaluation) }}" id="last_evaluation" placeholder="Última Evaluación">
        {!! $errors->first('last_evaluation', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
    </div>

        </div>
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </div>
</form>
