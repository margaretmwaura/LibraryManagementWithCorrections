<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $guarded = ['id'];
    protected $with = ['users'];
    public function Status()
    {
        return $this->belongsTo(Status::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('due_date', 'borrow_date','order_date','return_date')->withTimestamps();
    }
}
