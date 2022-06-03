<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access categories|create categories|update categories|delete categories', ['only' => ['index', 'store']]);
        $this->middleware('permission:create categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:update categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete categories', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $categories = Category::where('name', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $categories = Category::paginate(15);
        }

        return view('admin.categories.index')->with(['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $category = Category::create([
            'name' => $request->name,
        ]);

        if ($category) {
            request()->session()->flash('success', "Categoria [{$category->name}] cadastrada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('categories.index');
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
    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validator($request->all())->validate();

        $categoryName = $category->getOriginal()['name'];

        $category->name = $request->name;
        if ($category->save()) {
            request()->session()->flash('success', "Categoria [{$categoryName}] atualizada para [{$request->name}]!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            request()->session()->flash('success', "Categoria [{$category->type}] removida!");
        }

        return redirect()->route('categories.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', function($attribute, $value, $fail){
                if($value == "CONTRATOS"){
                    $fail(':attribute indisponível.');
                }
            }],
        ]);
    }
}
