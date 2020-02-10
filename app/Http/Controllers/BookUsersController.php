<?php

namespace App\Http\Controllers;

use App\Mail\collectbook;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookUsersController extends Controller
{
    //Instead of sending out two objects , the user we will be getting is the current user


    public function orderBook(Request $request)
    {
        $statuss=\App\Models\Status::where('name','NOTAVAILABLE')->get();
        $status=$statuss[0];
        $statusid=$status->id;

        $id=$request->input("id");
        $user_id=Auth::user()->id;
        $email=Auth::user()->email;

        $current=Carbon::now();
        $trialExpires=$current->addDays(14);

        $book=Book::find($id);
        $name=$book->name;

        $book->status_id=$statusid;
        $book->save();
        $book->users()->attach($user_id,['due_date'=>$trialExpires,'order_date'=>Carbon::now()]);

        $books=app('App\Http\Controllers\BooksController')->index();
        return response()->json($books);
    }
    public function reservebook(Request $request)
    {
        $statuss=\App\Models\Status::where('name','NOTRESERVABLE')->get();
        $status=$statuss[0];
        $statusid = $status->id;

        $id=$request->input("id");
        $user_id=Auth::user()->id;
        $email=Auth::user()->email;

        $book=Book::find($id);
        $name=$book->name;
        $book->status_id=$statusid;
        $book->save();
        $book->users()->attach($user_id,['borrow_date' => Carbon::now()]);

        $books=app('App\Http\Controllers\BooksController')->index();
        return response()->json($books);
    }
    public function getAllBooks()
    {
        $bookcollection=Book::has('users')->get();
        return response()->json($bookcollection);
    }
    public function sendingemails()
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
    public function returnbook(Request $request)
    {
        $email = $request->input('email');
        $book = Book::find($request->input('book.id'));
        $users = User::where('email',$email)->get();
        $id = $users[0]->id;
        $users = $request->input('book.users');
        try{
            foreach ($users as $user)
            {
                $details = $user['pivot'];
                $due = $details['due_date'];
               if($due !== null)
               {
                   $book->users()->wherePivot('due_date', $due)->updateExistingPivot($id, array('return_date'=>Carbon::now()), false);
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
        $user=User::find(18);
        $count=$user->books;
        Log::info("We are trying to get count ".$count);
        $collectionBorrowed = collect([]);
        $collectionReserved = collect([]);
        $count->each(function ($item, $key) use ($collectionBorrowed,$collectionReserved){
           if($item->pivot->due_date)
           {
               Log::info("This was a borrowed book push it to borrowed books");
               $collectionBorrowed->push($item);
           }
           else{
               Log::info("This was a reserved book push it to reserved books");
               $collectionReserved->push($item);
           }
        });


       return response()->json(array($collectionBorrowed,$collectionReserved));
    }
}
