<?php

namespace App\View\Components\Dashboard;

use App\Models\Receipt;
use Illuminate\View\Component;

class PendingReceipts extends Component
{
    public $receipts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->receipts = Receipt::query()
                                 ->whereBetween('expected_date', [date('Y-m-01'), date('Y-m-t')])
                                 ->orderBy('expected_date')
                                 ->take(5)
                                 ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components..dashboard.pending-receipts', [
            'receipts' => $this->receipts
        ]);
    }
}
