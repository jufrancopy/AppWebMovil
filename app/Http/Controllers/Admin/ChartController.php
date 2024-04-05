<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function appointments()
    {
        $mountlyCounts = Appointment::select(DB::raw("EXTRACT(MONTH FROM DATE_TRUNC('month', created_at)) as month"), DB::raw("count(*) as count"))
            ->groupBy("month")
            ->get()->toArray();
        $counts = array_fill(0, 12, 0);
        foreach ($mountlyCounts as $mountlyCount) {
            $index = $mountlyCount['month'] - 1;
            $counts[$index] = $mountlyCount['count'];
        }

        // dd($counts);
        return view('charts.appointments', compact('counts'));
    }

    public function doctorAppointments()
    {
        $now = Carbon::now();
        $start = $now->format('d-m-Y');
        $end = $now->subYear()->format('d-m-Y');

        return view('charts.doctors_appoinments_bar', get_defined_vars());
    }

    public function doctorAppointmentsJson(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $doctors = User::doctors()
            ->select('name')
            ->withCount([
                'attendedAppointments' => function ($query) use ($start, $end) {
                    $query->whereBetween('scheduled_date', [$start, $end]);
                },
                'cancelledAppointments' => function ($query) use ($start, $end) {
                    $query->whereBetween('scheduled_date', [$start, $end]);
                }
            ])
            ->orderByDesc('attended_appointments_count')
            ->get();

        $data = [];
        $data['categories'] = $doctors->pluck('name');

        // Citas atendidas
        $attendedAppointments['name'] = 'Citas Atendidas';
        $attendedAppointments['data'] = $doctors->pluck('attended_appointments_count');

        // Citas canceladas
        $cancellededAppointments['name'] = 'Citas Canceladas';
        $cancellededAppointments['data'] = $doctors->pluck('cancelled_appointments_count');;

        $series = [];
        $series[] = $attendedAppointments;
        $series[] = $cancellededAppointments;
        $data['series'] = $series;
        $doctors = User::doctors()
            ->select('name')
            ->withCount(['attendedAppointments', 'cancelledAppointments'])
            ->orderByDesc('attended_appointments_count')
            ->take(10)
            ->get();

        $data = [];
        $data['categories'] = $doctors->pluck('name');

        // Citas atendidas
        $attendedAppointments['name'] = 'Citas Atendidas';
        $attendedAppointments['data'] = $doctors->pluck('attended_appointments_count');

        // Citas canceladas
        $cancellededAppointments['name'] = 'Citas Canceladas';
        $cancellededAppointments['data'] = $doctors->pluck('cancelled_appointments_count');;

        $series = [];
        $series[] = $attendedAppointments;
        $series[] = $cancellededAppointments;
        $data['series'] = $series;

        return $data;
    }
}
