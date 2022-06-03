<?php

namespace App\Http\Livewire\Modals;

use App\Models\StudentFrequency;
use Livewire\Component;

class FrequencyModal extends Component
{
    public $groupclass;
    public $dates;

    public function mount($groupclass)
    {
        $this->groupclass = $groupclass;

        $dates = StudentFrequency::with(['student'])->where('group_classes_id', $groupclass->id)->orderByDesc('class_date')->get();

        $this->dates = $dates->groupBy(function($date){
            return $date->class_date;
        })->all();
    }
    public function render()
    {
        return view('livewire.modals.frequency-modal');
    }
}
