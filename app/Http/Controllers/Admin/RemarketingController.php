<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;

class RemarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::query();

        $statusProspected = Status::getDescriptionByConstant(Status::STATUS_REMARKETING);
        $students->where('status_id', $statusProspected->id);

        if ($request->has('filter')) {
            $students = $students->where(function( $query) {
                return $query->where('name', 'like', '%'.request('filter').'%')
                ->orWhere('email', 'like', '%'.request('filter').'%')
                ->orWhere('phone', 'like', '%'.request('filter').'%');
            });
        }

        if( $request->has('initial_date') &&
            $request->has('final_date') &&
            $request->initial_date != "" &&
            $request->initial_date != ""){
            $students = $students->whereBetween('created_at', [
                DateFormatHelper::convertToEN($request->initial_date) . " 00:00:00",
                DateFormatHelper::convertToEN($request->final_date) . " 23:59:59"
            ]);
        }

        $students = $students->orderBy('created_at')
                            ->paginate(15);

        return view('admin.remarketing.index', [
            'students' => $students
        ]);
    }
}
