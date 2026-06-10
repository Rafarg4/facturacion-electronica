<div class="form-group col-sm-6">
        <label for="name">Usuario:</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
    </div>

    <!-- Email -->
<div class="form-group col-sm-6">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}">
    </div>

    <!-- Rol -->
<div class="form-group col-sm-6">
        <label for="role">Rol:</label>
        <select id="role" name="role" class="form-control">
            @foreach($user->getRoleNames() as $role)
                <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
        </select>
    </div>

    <!-- Fecha de Creación -->
<div class="form-group col-sm-6">
        <label for="created_at">Creado:</label>
        <input type="text" id="created_at" name="created_at" class="form-control" value="{{ $user->created_at }}">
    </div>

