<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BillAnalyserService;
use App\Services\ContractAnalyserService;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // (new ContractAnalyserService())->handle();
        // (new BillAnalyserService())->handle();
        return view('home');
    }
}
