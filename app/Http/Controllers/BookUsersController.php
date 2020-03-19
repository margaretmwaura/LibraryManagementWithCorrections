<?php

namespace App\Http\Controllers;

use App\Events\BookReturned;
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
    public function borrowBook(Request $request)
    {

        $status_id=Status::GetBookBorrowedNotCollectedId();

        Log::info("This is the book not available id " . $status_id);
        $id=$request->input("id");
        $user_id=Auth::user()->id;

        $current=Carbon::now();
        $trialExpires=$current->addDays(14);

        $book=Book::find($id);

        $book->status_id=$status_id;
        $book->save();
        $book->users()->attach($user_id,['due_date'=>$trialExpires,'borrow_date'=>Carbon::now()]);

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
        $book->users()->attach($user_id,['reserve_date' => Carbon::now()]);

        return response("Success",200);
    }
    public function getAllBooks()
    {
        $book_collection=Book::has('users')->get();
        Log::info("This are all the books which have users " . $book_collection);
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
        Log::info("These is the request " . $request);
        $flag = false;
        $collecting_status_id=Status::GetBookAwaitingCollectionId();
        $available_status_id = Status::GetBookAvailableId();
        $email = $request->input('email');
        $book = Book::find($request->input('book.id'));
        $id = User::where('email',$email)->get()->first()->id;
        $users = $request->input('book.users');
        Log::info($users);
        Log::info($id);

            try{
                foreach ($users as $user)
                {
                    $details = $user['pivot'];
                    $due = $details['due_date'];
                    $borrow_date = $details['borrow_date'];

                    if($due !== null)
                    {
                        $book->users()->wherePivot('due_date', $due)->updateExistingPivot($id, array('return_date'=>Carbon::now()), false);
                    }
                    if($due === null && $borrow_date === null)
                    {
                        $email = $user['email'];

                        Log::info("This is the email of the user " . $email);
                        $book->status_id=$collecting_status_id;
                        $book->save();
                        $flag = true;
                        $user_id = $user['id'];
                        $user = User::find($user_id);
                        Log::info("The user " . $user);
//                        Event::fire(new BookReturned($user,$book));
                    }
                }
            }
            catch (\Exception $e)
            {
                Log::info("The reasons for not getting the collection " . $e->getMessage());
            } finally {
                if($flag == false)
                {
                    $book->status_id = $available_status_id;
                    $book->save();
                }
            }

    }
    public function getBooks()
    {
        $user=User::find(Auth::user()->id);
        $count=$user->books()->whereNull('book_user.deleted_at')->get();
        $collectionBorrowed = collect([]);
        $collectionReserved = collect([]);
        $count->each(function ($item, $key) use ($collectionBorrowed,$collectionReserved){
           if($item->pivot->due_date && $item->pivot->borrow_date)
           {
               if($item->pivot->status == 0)
               {
                   $collectionBorrowed->push($item);
               }
           }
           else{
               $collectionReserved->push($item);
           }
        });


       return response()->json(array($collectionBorrowed,$collectionReserved));
    }
    public function makeBookAvailable(Request $request)
    {
        Log::info("This is the data for not collected book request " . $request);
        $status_id=Status::GetBookAvailableId();
        $book = Book::find($request->input('id'));
        try {
            $user = $book->users()
                ->wherePivot('reserve_date', '!=' , null )
                ->wherePivot('borrow_date','=', null)
                ->firstOrFail();

            Log::info("The user retrieved " . $user);
            $book->users()
                ->wherePivot('reserve_date', '!=' , null )
                ->wherePivot('borrow_date','=', null)
                ->updateExistingPivot($user->id, array('status'=>1,'borrow_date'=>null,'due_date'=>null,'return_date' => null), false);
        }
        catch (\Exception $exception)
        {
            Log::info("Records not updated " . $exception);
        }

        $book->status_id=$status_id;
        $book->save();

    }
    public function collectBorrowedBook(Request $request)
    {
        $status_id=Status::GetBookReservableId();
        $book_details = $request->input('pivot');
        Log::info("The data sent the user id " . $request->input('id') . "and the pivot data is " . $book_details['book_id'] .
            " this is the due date " . $book_details['due_date']);
        $book = Book::find($book_details['book_id']);

        $book->status_id=$status_id;
        $book->save();
        $book->users()->wherePivot('status', 0 )
                      ->wherePivot('due_date',$book_details['due_date'])
                      ->updateExistingPivot($request->input('id'), array('status'=>1), false);

    }
    public function collectReservedBook(Request $request)
    {
        Log::info("This is the received request " . $request->input('email'));

        $book_details = $request->input('pivot');

        $book_id = $book_details['book_id'];

        $user_email = $request->input('email');

        Log::info("This is the book id  " . $book_id );

        $status_id=Status::GetBookReservableId();

        Log::info("This is the book reservable id " . $status_id);

        $user = User::where('email', $user_email)->firstOrFail();

        Log::info("This is the user gotten " . $user->id);
        $user_id = $user->id;
        $current=Carbon::now();
        $trialExpires=$current->addDays(14);

        $book=Book::find($book_id);

        $book->status_id=$status_id;

        $book->save();

        $book->users()->wherePivot('status', 0 )
             ->wherePivot('reserve_date',$book_details['reserve_date'])
             ->updateExistingPivot($user_id, array('status'=>1,'due_date'=>$trialExpires,'borrow_date'=>Carbon::now()), false);

        return response("Success",200);
    }
    public function cancelBookBorrowing(Request $request)
    {

        Log::info("Cancelling book borrowing request data " . $request->input('id'));
        $current=Carbon::now();
        $user_id=Auth::user()->id;
        $book_id = $request->input('id');
        $book=Book::find($book_id);
        $book->users()
            ->wherePivot('due_date', '!=' , null )
            ->wherePivot('borrow_date','!=', null)
            ->updateExistingPivot($user_id, array('deleted_at'=>$current), false);

        $status_id=Status::GetBookAvailableId();
        $book->status_id=$status_id;
        $book->save();

    }
    public function cancelBookReserving(Request $request)
    {
        Log::info("Cancelling book reserving request data " . $request->input('id'));
        $current=Carbon::now();
        $user_id=Auth::user()->id;
        $book_id = $request->input('id');
        $book=Book::find($book_id);
        $book->users()
            ->wherePivot('reserve_date', '!=' , null )
            ->updateExistingPivot($user_id, array('deleted_at'=>$current), false);

        $status_id=Status::GetBookReservableId();
        $book->status_id=$status_id;
        $book->save();
    }

    //should have a function for toggling the collection status

}
