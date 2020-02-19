<?php


namespace App\Repository;


use App\Models\Book;
use App\Repository\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookRepository implements BookRepositoryInterface
{
    public function all()
    {
       return Book::all();
    }

    public function storeRecord($input,$id)
    {
       $book = new Book();
       $book->name = $input['name'];
       $book->category_id=$id;
       $book->year=$input['year'];
       $book->author=$input['author'];
       $book->description=$input['description'];
       $book->save();

    }

    public function deleteRecord($id)
    {
        $book = Book::find($id);
        Log::info("Data to be deleted " . $id);
        $book->delete();
    }

    public function updateRecord(Request $request)
    {
        try {
            $id = $request->input('id');
            Log::info("This is the id of the book while we are editting" . $id);
            $book = Book::find($id);
            $book->update($request->all());
        }
        catch (\Exception $e)
        {
            Log::info("There was an error");
        }


    }
}
