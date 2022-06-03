<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodSchedulesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $initialDate = Carbon::createFromFormat('d/m/Y', $request->period_initial_date);
        $finalDate = Carbon::createFromFormat('d/m/Y', $request->period_final_date);
        if($initialDate > $finalDate){
            return redirect()->back()->withErrors([
                'message' => 'A data inicial não pode ser maior que a final'
            ]);
        }

        $selectedClasses = $request['chk-class'];

        $existingSchedules = Schedule::whereBetween('initial_date', [
                                                        $initialDate->format('Y-m-d 00:00:00'),
                                                        $finalDate->format('Y-m-d 23:59:59'),
                                                    ])->get();

        if( count($selectedClasses) > 0 ){

            $groupClasses = GroupClass::whereIn('id', $selectedClasses)->get();

            foreach($groupClasses as $groupClass){

                $daysOfPeriod = $this->getDaysInRange($initialDate, $finalDate, $groupClass->day_of_week);
                $vDaysOfPeriod[] = $daysOfPeriod;

                foreach($daysOfPeriod as $key => $scheduleDay ){

                    $formattedInitialDate = new Carbon("{$scheduleDay} {$groupClass->time_schedule}");
                    $formattedFinalDate = (new Carbon("{$scheduleDay} {$groupClass->time_schedule}"))->addHour();

                    $name = $groupClass->type == 'VIP' ? '[VIP]'. $groupClass->name : $groupClass->name;

                    $schedule = [
                        'group_classes_id'=> $groupClass->id,
                        'name' => $name,
                        'initial_date' => $formattedInitialDate,
                        'final_date' => $formattedFinalDate,
                        'teacher_id' => $request->period_teacher
                    ];

                    $alreadyExistsSchedule = $existingSchedules
                                                ->where('group_classes_id', $groupClass->id)
                                                ->where('initial_date', $formattedInitialDate->format('Y-m-d H:i:s'))
                                                ->where('final_date', $formattedFinalDate->format('Y-m-d H:i:s'));

                    if( count($alreadyExistsSchedule) == 0  ){
                        Schedule::create($schedule);
                    }
                }
            }

        }

        if(count(session('links')) >= 1){
            return redirect(session('links')[1]);
        }

        return redirect()->back();
    }

    public function getDaysInRange($dateFromString, $dateToString, $dayOfWeek)
    {
        $week_days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];

        $dateFrom = new \DateTime($dateFromString);

        $dateTo = new \DateTime($dateToString);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if ($dayOfWeek != $dateFrom->format('N')) {
            $dateFrom->modify('next ' . $week_days[$dayOfWeek] );
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = $dateFrom->format('Y-m-d');
            $dateFrom->modify('+1 week');
        }

        return $dates;
    }
}
