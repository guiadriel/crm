<?php

namespace App\Http\Livewire\Modals;

use App\Models\Student;
use App\Models\StudentRemarketing;
use Carbon\Carbon;
use Livewire\Component;

class StudentRemarketingTimelineForm extends Component
{
    public $date, $who_contacted, $type;
    public $student;

    protected $rules = [
        'date' => 'required',
        'who_contacted' => 'required',
        'type' => 'required',
    ];

    protected $listeners = ['setStudent'];

    public function setStudent($student){

        $this->student = Student::find($student);
    }

    public function createRecord()
    {
        $this->validate( $this->rules );

        StudentRemarketing::create([
            'student_id' => $this->student->id,
            'contact_date' => Carbon::createFromFormat('Y-m-d', $this->date)->format('d/m/Y'),
            'who_contacted' => $this->who_contacted,
            'type' => $this->type,
        ]);

        $this->emitTo('modals.student-remarketing-timeline','load');
    }

    public function mount()
    {
        $this->who_contacted = auth()->user()->name;
    }

    public function render()
    {
        return view('livewire.modals.student-remarketing-timeline-form');
    }
}
