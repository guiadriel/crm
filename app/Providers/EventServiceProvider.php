<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Contract;
use App\Models\ContractPayment;
use App\Models\Receipt;
use App\Models\Student;
use App\Observers\BillObserver;
use App\Observers\ContractObserver;
use App\Observers\ContractPaymentObserver;
use App\Observers\ReceiptObserver;
use App\Observers\StudentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Contract::observe(ContractObserver::class);
        ContractPayment::observe(ContractPaymentObserver::class);
        Receipt::observe(ReceiptObserver::class);
        Bill::observe(BillObserver::class);
        Student::observe(StudentObserver::class);
    }
}
