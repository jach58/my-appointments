<?php

namespace App\Console\Commands;

use App\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes vía FCM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Buscando citas médicas confirmadas en las proximas 24 horas.');

        $now = Carbon::now();

        $headers = ['id', 'scheduled_date', 'scheduled_time', 'patient_id'];

        $appointmentsTomorrow = $this->getAppointments24Hours($now->copy());
        $this->table($headers, $appointmentsTomorrow->toArray());

        foreach ($appointmentsTomorrow as $appointment) {
            $appointment->patient->sendFCM('No olvides tu cita mañana a esta hora.');
            $this->info('Mensaje FCM enviado 24h antes al paciente (ID): ' . $appointment->patient_id);
        }

        $appointmentsNextHour = $this->getAppointmentsNextHour($now->copy());
        $this->table($headers, $appointmentsNextHour->toArray());

        foreach ($appointmentsNextHour as $appointment) {
            $appointment->patient->sendFCM('Tienes una cita en 1 hora. Te esperamos.');
            $this->info('Mensaje FCM enviado faltando 1h al paciente (ID): ' . $appointment->patient_id);
        }
    }

    private function getAppointments24Hours($now)
    {

        return Appointment::where('status', 'Confirmada')
            ->where('scheduled_date', $now->addDay()->toDateString())
            ->where('scheduled_time', '>=', $now->copy()->subMinutes(3)->toTimeString())
            ->where('scheduled_time', '<', $now->copy()->addMinutes(2)->toTimeString())
            ->get(['id', 'scheduled_date', 'scheduled_time', 'patient_id']);
    }

    private function getAppointmentsNextHour($now)
    {
        return Appointment::where('status', 'Confirmada')
            ->where('scheduled_date', $now->addHour()->toDateString())
            ->where('scheduled_time', '>=', $now->copy()->subMinutes(3)->toTimeString())
            ->where('scheduled_time', '<', $now->copy()->addMinutes(2)->toTimeString())
            ->get(['id', 'scheduled_date', 'scheduled_time', 'patient_id']);
    }
}
