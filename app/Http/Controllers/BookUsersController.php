<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Status;

class BookUsersController extends Controller
{
    //Instead of sending out two objects , the user we will be getting is the current user


    public function orderBook(Request $request)
    {

        $status_id=Status::GetBookReservableId();

        Log::info("This is the book not available id " . $status_id);
        $id=$request->input("id");
        $user_id=Auth::user()->id;

        $current=Carbon::now();
        $trialExpires=$current->addDays(14);

        $book=Book::find($id);

        $book->status_id=$status_id;
        $book->save();
        $book->users()->attach($user_id,['due_date'=>$trialExpires,'order_date'=>Carbon::now()]);

        return response("Success",200);
    }
    public function reserveBook(Request $request)
    {
        $status_id = Status::GetBookNotAvailableId();
        $id=$request->input("id");
        $user_id=Auth::user()->id;
        $book=Book::find($id);
        $book->status_id=$status_id;
        $book->save();
        $book->users()->attach($user_id,['borrow_date' => Carbon::now()]);

        return response("Success",200);
    }
    public function getAllBooks()
    {
        $book_collection=Book::has('users')->get();
        return response()->json($book_collection);
    }
    public function sending_emails()
    {
      $data = Book::with('users')->whereNotNull("due_date")->get();
        try{
            $data->each(function ($item, $key) {
                $due=$item->due_date;
                $oder=$item->order_date;
                $due_date=\Carbon\Carbon::createFromFormat('Y-m-d H:s:i',$due);
                $order_date=\Carbon\Carbon::createFromFormat('Y-m-d H:s:i',$oder);
                $diff=$due_date->diffInDays($order_date);
            });
        }
        catch (\Exception $e)
        {
            Log::info("The reasons for not getting the collection " . $e->getMessage());
        }
    }
    public function return_book(Request $request)
    {
        $email = $request->input('email');
        $book = Book::find($request->input('book.id'));
        $id = User::where('email',$email)->get()->first()->id;
        $users = $request->input('book.users');
        Log::info($users);
        Log::info($id);
        dd($users);
        try{
            foreach ($users as $user)
            {
                $details = $user['pivot'];
                $due = $details['due_date'];
               if($due !== null)
               {
                   $book->users()->wherePivot('due_date', $due)->updateExistingPivot($id, array('return_date'=>Carbon::now()), false);
                   $book->status_id=Status::GetBookAvailableId();
                   $book->save();
               }
            }
        }
        catch (\Exception $e)
        {
            Log::info("The reasons for not getting the collection " . $e->getMessage());
        }
    }
    public function getBooks()
    {
        $user=User::find(Auth::user()->id);
        $count=$user->books;
        Log::info("We are trying to get count ".$count);
        $collectionBorrowed = collect([]);
        $collectionReserved = collect([]);
        $count->each(function ($item, $key) use ($collectionBorrowed,$collectionReserved){
           if($item->pivot->due_date)
           {
               $collectionBorrowed->push($item);
           }
           else{
               $collectionReserved->push($item);
           }
        });


       return response()->json(array($collectionBorrowed,$collectionReserved));
    }
}
