<?php

namespace App\Http\Livewire\GroupClass;

use Livewire\Component;

class Tabs extends Component
{
    public $groupclass;

    public function mount($groupclass)
    {
        $this->groupclass = $groupclass;
    }

    public function render()
    {
        return view('livewire.group-class.tabs',[
            'groupclass' => $this->groupclass
        ]);
    }
}
