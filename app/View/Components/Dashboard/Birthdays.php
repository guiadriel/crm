<?php

namespace App\View\Components\Dashboard;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Birthdays extends Component
{
    public $students;

    public $saturdayStudents;
    public $sundayStudents;

    public $currentDayOfWeek;
    /**
     * Create a new component instance.
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->currentDayOfWeek = date('w');
        $this->saturdayStudents = collect();
        $this->sundayStudents = collect();

        $now = Carbon::now();

        $weekStartDate = $now->startOfWeek()->subDays(2)->format('d');
        $weekEndDate = $now->endOfWeek()->format('d');

        // if( in_array($this->currentDayOfWeek,['1', '5'])){

        //     $saturdayDate = $this->currentDayOfWeek == '1' ? Carbon::now()->subDays(2) : Carbon::now()->addDays(1);
        //     $this->saturdayStudents = $this->getStudentsByDateAndMonth( $saturdayDate->format('d'));

        //     $sundayDate = $this->currentDayOfWeek == '1' ? Carbon::now()->subDays(1) : Carbon::now()->addDays(2);;
        //     $this->sundayStudents = $this->getStudentsByDateAndMonth( $sundayDate->format('d'));
        // }

        // $this->students = $this->getStudentsByDateAndMonth();

        $month = date('m');

        $this->students = Student::query()
        ->whereMonth('birthday_date', $month)
        ->whereRaw("DAY(birthday_date) BETWEEN {$weekStartDate} AND {$weekEndDate}")
        ->orderByRaw('DAY(birthday_date)')
        ->get();
    }

    // public function getStudentsByDateAndMonth($date = null, $month = null)
    // {
    //     if( !$date )
    //         $date = date('d');

    //     if( !$month)
    //         $month = date('m');


    //     return Student::query()
    //     ->whereMonth('birthday_date', $month)
    //     ->whereDay('birthday_date', $date)
    //     ->get();
    // }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components..dashboard.birthdays');
    }
}
