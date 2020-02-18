<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $guarded = ['id'];
    protected $with = ['users'];
    protected $appends = ['is_available','is_reservable','is_not_available'];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('due_date', 'borrow_date','order_date','return_date')->withTimestamps();
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
        $is_available = $this->status->id;
        if($is_available == Status::GetBookReservableId())
        {
            return true;
        }
        return false;
    }

    public function getIsNotAvailableAttribute()
    {
        $is_available = $this->status->id;
        if($is_available == Status::GetBookNotAvailableId())
        {
            return true;
        }
        return false;
    }
}
