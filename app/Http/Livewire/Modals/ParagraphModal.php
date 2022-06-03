<?php

namespace App\Http\Livewire\Modals;

use App\Models\Paragraph;
use Illuminate\Http\Request;
use Livewire\Component;

class ParagraphModal extends Component
{
    public $groupclass;
    public $isOpen = false;

    public $updateMode = false;

    public $p_date;
    public $book;
    public $page;
    public $last_word;
    public $activity;
    public $observation;
    public $teacher;

    public $teachers;
    public $books;

    protected $listeners = [
        'toggleParagraphModal' => 'toggle',
        'create' => 'create'
    ];

    /**
     * The livewire rules function
     *
     * @return void
     */
    public function rules()
    {
        return [
            'date' => 'required',
        ];
    }

    /**
     * The livewire mount function
     *
     * @param  mixed $groupclass
     * @return void
     */
    public function mount($groupclass)
    {
        $this->groupclass = $groupclass;
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function create()
    {
        $paragraph = Paragraph::create($this->modelData());

        if( $paragraph ){
            request()->session()->flash('success', 'Renderizado com sucesso');
        }

        // $this->emit('toggleParagraphModal');
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'date' => $this->date,
            'group_classes_id' => $this->groupclass->id,
        ];
    }


    public function render()
    {
        return view('livewire.modals.paragraph-modal');
    }
}
