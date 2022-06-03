<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\BooksActivity;
use Illuminate\Http\Request;

class BookActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Books $book)
    {
        return $book->activities;
    }
}
