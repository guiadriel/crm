<?php

namespace App\View\Components\Dashboard;

use App\Models\Bill;
use App\Models\Status;
use Illuminate\View\Component;

class PendingBills extends Component
{

    public $bills;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $statusPago = Status::getStatusPago();
        $this->bills = Bill::where('status_id', '<>', $statusPago->id )->orderBy('due_date')->take(5)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components..dashboard.pending-bills');
    }
}
