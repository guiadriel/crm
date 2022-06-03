<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateFormatHelper;
use App\Traits\FrequencyTrait;
use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\GroupClass;
use App\Models\Paragraph;
use App\Models\StudentFrequency;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PDF;

class ParagraphController extends Controller
{
    use FrequencyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = GroupClass::all();
        $books = Books::all();

        return view('admin.paragraph.index', [
            'groupclass' => $classes,
            'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( !$request->has('class_id')){
            request()->session()->flash('error', "Nenhuma classe selecionada, não é possível continuar!");
            return redirect()->back();
        }

        $groupClass = GroupClass::find($request->class_id);
        $teachers   = Teacher::all();
        $books      = Books::all();

        return view('admin.paragraph.new', [
            'teachers' => $teachers,
            'groupclass' => $groupClass,
            'books' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paragraph = Paragraph::create([
           'group_classes_id'=> $request->class_id,
           'date' => $request->date,
           'teacher_id' =>  $request->teacher,
           'book_id' => $request->book,
           'activity' => join("|", $request->activity ),
           'page' => $request->page,
           'last_word' => $request->last_word,
           'observation' => $request->observations
        ]);

        if( $paragraph->groupClass->type == \App\Models\GroupClass::TYPE_TURMA) {
            $this->insertFrequencies($request, $paragraph->groupClass);
        }

        if( $paragraph->groupClass->type == \App\Models\GroupClass::TYPE_VIP){
            $this->insertVipFrequencies($paragraph->groupClass, $request->date, $request->is_absent);
        }

        if ($paragraph) {
            request()->session()->flash('success', "Parágrafo cadastrado com sucesso!");
        }


        return redirect()->route('class.edit', $request->class_id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, GroupClass $groupClass)
    {
        $qty = $request->qty;
        $book = Books::find($request->book);
        $groupClass = GroupClass::find($request->groupclass);

        return PDF::loadView('admin.paragraph.show', [
            'groupClass' => $groupClass,
            'book' => $book,
            'qty' => $qty,
        ])
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
            // ->download('nome-arquivo-pdf-gerado.pdf')
            ->stream()
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Paragraph $paragraph)
    {
        $teachers   = Teacher::all();
        $books      = Books::all();

        $frequencies = $paragraph->groupClass->frequencies()->where('class_date', DateFormatHelper::convertToEN($paragraph->date))->get();
        return view('admin.paragraph.edit')->with([
            'paragraph' => $paragraph,
            'groupclass' => $paragraph->groupClass,
            'teachers' => $teachers,
            'books' => $books,
            'frequencies' => $frequencies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paragraph $paragraph)
    {
        $last_date = $paragraph->date;
        $paragraph->date = $request->date;
        $paragraph->teacher_id = $request->teacher;
        $paragraph->book_id = $request->book;
        $paragraph->activity = join("|",$request->activity);
        $paragraph->page = $request->page;
        $paragraph->last_word = $request->last_word;
        $paragraph->observation = $request->observations;

        if( $paragraph->groupClass->type == \App\Models\GroupClass::TYPE_TURMA) {
            $request->class_id = $paragraph->groupClass->id;

            $frequencies_to_delete = StudentFrequency::where('group_classes_id', $request->class_id)
            ->where('class_date', DateFormatHelper::convertToEN($last_date) );
            $frequencies_to_delete->delete();

            $this->insertFrequencies($request, $paragraph->groupClass);
        }

        if ( $paragraph->save() ) {
            request()->session()->flash('success', "Parágrafo cadastrado com sucesso!");
        }

        return redirect()->route('class.edit', $paragraph->groupClass->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paragraph $paragraph)
    {
        $groupclass = $paragraph->groupClass->id;

        StudentFrequency::where('group_classes_id', $groupclass)
            ->where('class_date', DateFormatHelper::convertToEN($paragraph->date) )->delete();


        if ($paragraph->delete()) {
            request()->session()->flash('success', "Registro removido removido!");
        }

        return redirect()->route('class.edit', $groupclass);

    }
}
