@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Mis citas</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if(session('notification'))
      <div class="alert alert-success" role="alert">
        {{ session('notification') }}
      </div>
      @endif
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
            href="#confirmed-appoinments" role="tab" aria-controls="confirmed-appoinments"
            aria-selected="true">Mis próximas citas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
            href="#pending-appointments" role="tab" aria-controls="pending-appointments"
            aria-selected="false">Citas por confirmar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
            href="#old-appointments" role="tab" aria-controls="old-appointments"
            aria-selected="false">Historial de citas atendidas</a>
        </li>
      </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="confirmed-appoinments"
        role="tabpanel" aria-labelledby="pills-home-tab">
        @include('appointments.tables.confirmed')
      </div>
      <div class="tab-pane fade" id="pending-appointments"
        role="tabpanel" aria-labelledby="pills-profile-tab">
        @include('appointments.tables.pending')
      </div>
      <div class="tab-pane fade" id="old-appointments"
        role="tabpanel" aria-labelledby="pills-profile-tab">
        @include('appointments.tables.old')
      </div>
    </div>
  </div>
@endsection