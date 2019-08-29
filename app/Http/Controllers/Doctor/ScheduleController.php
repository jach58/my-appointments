<?php

namespace App\Http\Controllers\Doctor;

use App\WorkDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class ScheduleController extends Controller
{
    private $days = [
        'Lunes', 'Martes', 'Miércoles',
        'Jueves', 'Viernes', 'Sábado', 'Domingo'
    ];

    public function edit()
    {
        $workDays = WorkDay::where('user_id', auth()->id())->get();

        $morningHours = $this->halfHourTimes(18000,41400,1800, '');
        $afternoonHours = $this->halfHourTimes(43200,84600,1800, '');

        if(count($workDays) > 0) {
            $workDays->map(function($workDay) {
                $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
                $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
                $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
                $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');

                return $workDay;
            });
        } else {
            $workDays = collect();
            for($i = 0; $i < 7 ;$i++)
                $workDays->push(new WorkDay());
        }

        $days = $this->days;
        return view('schedule', compact('workDays','days', 'morningHours', 'afternoonHours'));
    }

    public function store(Request $request)
    {
        $active = $request->input('active') ?: [];
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');

        $errors = [];

        for($i = 0; $i < 7; $i++) {
            if($morning_start[$i] > $morning_end[$i]) {
                $errors[] = 'Las horas del turno de mañana son inconsistentes para el día '.
                    $this->days[$i] . '.';
            }

            if($afternoon_start[$i] > $afternoon_end[$i]) {
                $errors[] = 'Las horas del turno de tarde son inconsistentes para el día '.
                $this->days[$i] . '.';
            }
            WorkDay::updateOrCreate(
                [
                    'day' => $i,
                    'user_id' => auth()->id()
                ],
                [
                    'active' => in_array($i, $active),
                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],
                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i]
                ]
            );
        }

        if(count($errors) > 0)
            return back()->with(compact('errors'));

        $notification = 'Los cambios se han guardado correctamente.';

        return back()->with(compact('notification'));
    }

    private function halfHourTimes( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
        $times = array();
        if ( empty( $format ) ) {
            $format = 'g:i A';
        }
        foreach ( range( $lower, $upper, $step ) as $increment ) {
            $increment = gmdate( 'H:i', $increment );
            list( $hour, $minutes ) = explode( ':', $increment );
            $date = new DateTime( $hour . ':' . $minutes );
            $times[(string) $increment] = $date->format( $format );
        }

        return $times;
    }
}
