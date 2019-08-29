@extends('layouts.panel')

@section('styles')
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
@endsection

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nueva médico</h3>
      </div>
      <div class="col text-right">
        <a href="{{ url('doctors') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
      </div>
      </div>
    </div>
    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form action="{{ url('doctors')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Nombre del médico</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="form-group">
          <label for="dni">DNI</label>
          <input type="text" name="dni" class="form-control" value="{{ old('dni') }}">
        </div>
        <div class="form-group">
          <label for="address">Dirección</label>
          <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <div class="form-group">
          <label for="phone">Teléfono / móvil</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="text" name="password" class="form-control" value="{{ str_random(6) }}">
        </div>
        <div class="form-group">
          <label for="specialties">Especialidades</label>
          <select name="specialties[]" id="specialties" title="Seleccione una o varias"
            data-style="btn-outline-secondary" class="form-control selectpicker" multiple>
            @foreach($specialties as $specialty)
            <option value="{{ $specialty->id }}">{{ $specialty->name}}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
@endsection
