<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">Nombre del rol</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role?->name) }}" id="name" placeholder="Nombre">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="guard_name" class="form-label">Gurdado en</label>
            <input type="text" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror" value="{{ old('guard_name', $role?->guard_name) }}" id="guard_name" placeholder="Guardia">
            {!! $errors->first('guard_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
<div class="form-group mb-2">
    <label>Permisos disponibles:</label>
    <div class="row">
        @foreach($permissions as $permiso)
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}"
                        class="form-check-input"
                        id="permiso_{{ $permiso->id }}"
                        {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
                    <label class="form-check-label" for="permiso_{{ $permiso->id }}">
                        {{ $permiso->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>