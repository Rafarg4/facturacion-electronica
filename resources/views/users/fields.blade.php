<!-- Name Field -->
<div class="form-group col-sm-3">
    {!! Form::label('name', 'Usuario:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-3">
    {!! Form::label('password', 'Password:') !!}
   {{ Form::password('password', ['class' => 'form-control dd','id'=>'password','v-model'=>'password']) }}
</div>
<!-- Role Field -->
<div class="form-group col-sm-3">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', $roleItems, isset($user) ? $user->roles()->pluck('id'):[], ['class' => 'form-control','placeholder'=>'Seleccione'])
    !!}
</div>
<!-- Checkbox para habilitar caja -->
<div class="form-group col-sm-3">
    <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" id="habilitarCaja">
        <label class="form-check-label" for="habilitarCaja">
            Habilitar Caja
        </label>
    </div>
</div>

<!-- Caja select - oculto por defecto -->
<div class="form-group col-sm-3" id="cajaSelect" style="display: none;">
    {!! Form::label('caja', 'Caja:') !!}
    <select name="caja" class="form-control">
        <option value="">Seleccione una caja</option>
        @foreach($cajas as $caja)
            <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
        @endforeach
    </select>
</div>

<!-- Script para mostrar/ocultar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('habilitarCaja');
        const cajaSelect = document.getElementById('cajaSelect');

        checkbox.addEventListener('change', function () {
            cajaSelect.style.display = this.checked ? 'block' : 'none';
        });
    });
</script>
