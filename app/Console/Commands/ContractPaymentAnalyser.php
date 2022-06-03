<?php

namespace App\Console\Commands;

use App\Services\BillAnalyserService;
use App\Services\ContractAnalyserService;
use Illuminate\Console\Command;

class ContractPaymentAnalyser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:analyse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyse the contracts payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contractAnalyser = (new ContractAnalyserService())->handle();
        $billAnalyser = (new BillAnalyserService())->handle();

        // return 0;
    }
}
