<?php

namespace App\Traits;

use App\Helpers\DateFormatHelper;
use App\Models\GroupClass;
use App\Models\StudentFrequency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait FrequencyTrait
{
    public function insertFrequencies(Request $request, $groupClass = null)
    {
        if( !$request->has('class_id') && $groupClass == null){
            request()->session()->flash('error', "Nenhuma turma selecionada, não é possível continuar!");
            return redirect()->back();
        }

        $groupClass = $groupClass ?? GroupClass::find($request->class_id);

        // DB::transaction(function () use($request, $groupClass){
            foreach($groupClass->students as $student){

                $is_attend = isset($request->is_attend) && \in_array($student->id, $request->is_attend) ? true : false;

                $classDate = Carbon::createFromFormat('d/m/Y', $request->date);



                $existingStudentFrequencyAtClass = StudentFrequency::where('group_classes_id', $groupClass->id)
                                                                    ->where('student_id', $student->id)
                                                                    ->where('class_date', $classDate->format('Y-m-d'))->first();

                if( !$existingStudentFrequencyAtClass ){
                    StudentFrequency::create([
                        'group_classes_id' => $groupClass->id,
                        'student_id' => $student->id,
                        'class_date' => $classDate->format('d/m/Y'),
                        'is_attend' => $is_attend
                    ]);
                }else {

                    $existingStudentFrequencyAtClass->is_attend = $is_attend;
                    $existingStudentFrequencyAtClass->save();
                }
            }

        // });
    }

    public function insertVipFrequencies(GroupClass $groupClass, $date, $is_absent)
    {
        if( !$groupClass){
            request()->session()->flash('error', "Nenhuma turma selecionada, não é possível continuar!");
            return redirect()->back();
        }

        foreach($groupClass->students as $student){

            StudentFrequency::create([
                'group_classes_id' => $groupClass->id,
                'student_id' => $student->id,
                'class_date' => $date,
                'is_attend' => $is_absent ? false : true, // No check, a descrição está como "Não compareceu"
            ]);
        }

    }
}
