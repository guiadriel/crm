<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\StudentLog;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function created(Student $student)
    {
        if( $student->observations != "" ){

            StudentLog::create([
                'date_log' => now()->format('d/m/Y H:i:s'),
                'who_received' => auth()->user()->name,
                'description' => $student->observations,
                'type' => StudentLog::TYPE_SYSTEM,
                'student_id' => $student->id
            ]);
        }
    }

    public function updating(Student $student)
    {
        if( $student->getOriginal()['observations'] != $student->observations) {
            StudentLog::create([
                'date_log' => now()->format('d/m/Y H:i:s'),
                'who_received' => auth()->user()->name,
                'description' => $student->observations,
                'type' => StudentLog::TYPE_SYSTEM,
                'student_id' => $student->id
            ]);
        }
    }
}
