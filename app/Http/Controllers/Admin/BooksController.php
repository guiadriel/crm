<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\BooksActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access books|create books|update books|delete books', ['only' => ['index', 'store']]);
        $this->middleware('permission:create books', ['only' => ['create', 'store']]);
        $this->middleware('permission:update books', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete books', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $books = Books::where('name', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $books = Books::paginate(15);
        }

        return view('admin.books.index')->with(['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        if( !$request->activities){
            request()->session()->flash('error', "Informe as atividades antes de continuar!");
            return redirect()->back()->withInput();
        }

        $book = Books::create([
            'name' => $request->name,
        ]);

        if ($book) {


            foreach ($request->activities as $activity) {
                BooksActivity::create([
                    'book_id' => $book->id,
                    'name' => $activity,
                ]);
            }

            request()->session()->flash('success', "Book [{$book->name}] cadastrado com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Books $book)
    {
        return view('admin.books.edit')->with([
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $book)
    {
        $this->validator($request->all())->validate();

        $bookName = $book->getOriginal()['name'];

        $book->name = $request->name;

        if ($book->save()) {
            BooksActivity::where('book_id', '=', $book->id)->delete();

            foreach ($request->activities as $activity) {
                BooksActivity::create([
                    'book_id' => $book->id,
                    'name' => $activity,
                ]);
            }

            request()->session()->flash('success', "Book [{$bookName}] atualizado!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Books $book)
    {
        if ($book->delete()) {
            request()->session()->flash('success', "Book [{$book->name}] removido!");
        }

        return redirect()->route('books.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }
}
