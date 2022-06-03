<?php

namespace App\Http\Livewire\Modals;

use App\Models\Student;
use App\Models\StudentRemarketing;
use Livewire\Component;

class StudentRemarketingTimeline extends Component
{
    public $records;
    public $student = 0;
    protected $listeners = ['openModal' => 'openModal', 'load' => 'loadTimeline'];

    public function mount()
    {
        $this->records = [];
    }

    public function loadTimeline()
    {
        if( $this->student instanceof Student){
            $this->records = StudentRemarketing::where('student_id', $this->student->id)->orderBy('contact_date')->get();
        }

        $this->dispatchBrowserEvent('reloadMarketingModal');
    }

    public function openModal($student_id)
    {
        $this->student = Student::find($student_id);
        $this->loadTimeline();
        $this->emitTo('modals.student-remarketing-timeline-form','setStudent', $student_id);
        $this->dispatchBrowserEvent('firstStudentOpenModal');
    }

    public function render()
    {
        return view('livewire.modals.student-remarketing-timeline');
    }
}
