<?php

namespace App\Http\Controllers\Admin\Api;

use App\Helpers\CurrencyHelper;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $initialDate = date('Y-m-01');
        $finalDate = date('Y-m-t');

        if($request->has('filter')){
            $filter = $request->filter;

            switch($filter) {

                case 'period':
                    $initialDate = DateFormatHelper::convertToEN($request->initial_date);
                    $finalDate = DateFormatHelper::convertToEN($request->final_date);
                    break;
                case 'current':
                    $initialDate = date('Y-m-01');
                    $finalDate = date('Y-m-t');
                    break;
                default:
                    $formattedDate = new DateTime();
                    $intFilterDate = (int) $filter;

                    $formattedDate->modify("-{$intFilterDate} days");

                    $initialDate = $formattedDate->format('Y-m-d');
                    $finalDate = date('Y-m-d');
                    break;
            }

        }

        return Entry::with(['category','subCategory', 'contract'])
                    ->whereBetween('payment_date', [$initialDate, $finalDate])
                    ->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $amountValue = CurrencyHelper::instance()->brl2decimal($request->amount);

        $entry = Entry::create([
            'description' => $request->description,
            'type' => $request->type,
            'value' => $amountValue,
            'category_id' => $request->category,
            'observations' => $request->observations,
        ]);

        if ($entry) {
            request()->session()->flash('success', "Lançamento [{$entry->description}] cadastrado com sucesso!");
        }

        return $entry;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'description' => ['required', 'string', 'max:255'],
        ]);
    }
}
