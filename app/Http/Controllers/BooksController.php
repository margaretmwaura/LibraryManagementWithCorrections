<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $category=$request->input("category");
        $id= Category::whereName($category)->first()->id;
        Log::info("This is the request " . $request);
        $this->bookRepository->storeRecord($request->all(),$id);
       return response("Success",200);
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
        return response("Success",200);
    }
    public function destroy($id)
    {
       $this->bookRepository->deleteRecord($id);
        return response("Success",200);
    }
}
