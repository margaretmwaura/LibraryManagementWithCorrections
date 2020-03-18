<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table='status';
    protected $fillable=[
        'name',
    ];

    public function Book()
    {
        return $this->hasMany(Book::class);
    }
    public function scopeGetBookAvailableId($query)
    {
        return $query->where('name','AVAILABLE')->get()->first()->id;
    }

    public function scopeGetBookReservableId($query)
    {
        return $query->where('name','RESERVABLE')->get()->first()->id;
    }

    public function scopeGetBookBorrowedNotCollectedId($query)
    {
        return $query->where('name','BORROWED NOT COLLECTED')->get()->first()->id;
    }
    public function scopeGetBookNotAvailableId($query)
    {
        return $query->where('name','NOT AVAILABLE')->get()->first()->id;
    }

    public function scopeGetBookAwaitingCollectionId($query)
    {
        return $query->where('name','AWAITING COLLECTION')->get()->first()->id;
    }

}
