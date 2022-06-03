<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    protected $listeners = [
        'toggleModal' => 'toggle',
        'storeModal' => 'store', ];

    public function toggle()
    {
        if ($this->isOpen) {
            $this->isOpen = false;
        } else {
            $this->isOpen = true;
        }

        $this->emit('userStore');
    }

    public function flashMessage()
    {
        request()->session()->flash('success', 'Renderizado com sucesso');
    }

    public function render()
    {
        return view('livewire.partials.modal');
    }
}
