<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Book extends Model
{

    protected $guarded = ['id'];
    protected $with = ['users'];
    protected $appends = ['is_available','is_reservable','is_not_available','is_awaiting_collection','is_borrowed_not_collected'];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('due_date', 'borrow_date','reserve_date','return_date','status')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getIsAvailableAttribute()
    {
        $is_available = $this->status->id;
        if($is_available == Status::GetBookAvailableId())
        {
            return true;
        }
        return false;
    }

    public function getIsReservableAttribute()
    {
        $is_reservable = $this->status->id;
        if($is_reservable == Status::GetBookReservableId())
        {
            return true;
        }
        return false;
    }

    public function getIsNotAvailableAttribute()
    {
        $is_not_available = $this->status->id;
        if($is_not_available  == Status::GetBookNotAvailableId())
        {
            return true;
        }
        return false;
    }

    public function getIsAwaitingCollectionAttribute()
    {
        $is_awaiting_collection = $this->status->id;
        if($is_awaiting_collection == Status::GetBookAwaitingCollectionId())
        {
            return true;
        }
        return false;
    }

    public function getIsBorrowedNotCollectedAttribute()
    {
        $is_borrowed_not_collected = $this->status->id;
        if($is_borrowed_not_collected == Status::GetBookBorrowedNotCollectedId())
        {
            return true;
        }
        return false;
    }
    public function getIsBorrowedCollectedAttribute()
    {

            if($this->users()->where(['return_date'=>null])->where(['order_date' => null])->exists())
            {
                $book_record = $this->users()->where(['return_date'=>null])->where(['order_date' => null])->first();
                Log::info("This is the book record " . $book_record);
                $isCollected = $book_record->collection_status;
            }
            else
            {
                $isCollected = 1;
            }


            return $isCollected;
    }
}
