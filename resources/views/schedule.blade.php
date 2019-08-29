@extends('layouts.panel')

@section('content')
  <form action="{{ url('/schedule') }}" method="POST">
    @csrf
    <div class="card shadow">
      <div class="card-header border-0">
        <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Gestionar horario</h3>
        </div>
        <div class="col text-right">
          <button type="submit" class="btn btn-sm btn-success">Guardar cambios</button>
        </div>
        </div>
      </div>
      <div class="card-body">
        @if(session('notification'))
        <div class="alert alert-success" role="alert">
          {{ session('notification') }}
        </div>
        @endif
        @if(session('errors'))
        <div class="alert alert-danger" role="alert">
          Los cambios se han guardado pero tener en cuenta que:
          <ul>
          @foreach(session('errors') as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
        </div>
        @endif
      </div>
      <div class="table-responsive">
          <!-- Projects table -->
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">Día</th>
              <th scope="col">Activo</th>
              <th scope="col">Turno día</th>
              <th scope="col">Turno tarde</th>
            </tr>
          </thead>
          <tbody>
            @foreach($workDays as $key => $workDay)
            <tr>
              <th>{{ $days[$key] }}</th>
              <td>
                <label class="custom-toggle">
                  <input type="checkbox" name="active[]" value="{{ $key }}"
                    @if($workDay->active) checked @endif>
                  <span class="custom-toggle-slider rounded-circle"></span>
                </label>
              </td>
              <td>
                <div class="row">
                  <div class="col">
                    <select class="form-control" name="morning_start[]">
                      @foreach($morningHours as $key => $morningHour)
                      <option value="{{ $key }}"
                        @if($morningHour == $workDay->morning_start) selected @endif>
                        {{ $morningHour }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <select class="form-control" name="morning_end[]">
                      @foreach($morningHours as $key => $morningHour)
                      <option value="{{ $key }}"
                        @if($morningHour == $workDay->morning_end) selected @endif>
                        {{ $morningHour }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </td>
              <td>
                <div class="row">
                  <div class="col">
                    <select class="form-control" name="afternoon_start[]">
                      @foreach($afternoonHours as $key => $afternoonHour)
                      <option value="{{ $key }}"
                        @if($afternoonHour == $workDay->afternoon_start) selected @endif>
                        {{ $afternoonHour }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <select class="form-control" name="afternoon_end[]">
                      @foreach($afternoonHours as $key => $afternoonHour)
                      <option value="{{ $key }}"
                        @if($afternoonHour == $workDay->afternoon_end) selected @endif>
                        {{ $afternoonHour }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>
@endsection
