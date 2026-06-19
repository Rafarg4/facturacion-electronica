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

