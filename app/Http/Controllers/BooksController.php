<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{

    public $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository=$bookRepository;
        $this->middleware('Admin');
    }
    public function store(Request $request)
    {

        Log::info("This is the request " . $request);
       $books=$this->bookRepository->storeRecord($request->all());
        return response()->json($books);
    }
    public function index()
    {
        $books=$this->bookRepository->all();

        dd($books);
        return response()->json($books);
    }
    public function update(Request $request)
    {
        $this->bookRepository->updateRecord($request);
    }
    public function destroy($id)
    {
        $books=$this->bookRepository->deleteRecord($id);
        return response()->json($books);
    }
}
