<?php

namespace App\View\Components\Dashboard;

use App\Models\Schedule;
use Illuminate\View\Component;

class DailySchedule extends Component
{
    public $schedules;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schedules = Schedule::whereBetween('initial_date', [date('Y-m-d 00:00:00') ,date('Y-m-d 23:59:59')])->orderBy('initial_date')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components..dashboard.daily-schedule');
    }
}
