<?php

namespace App\Models;

use App\Models\Book;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
    public function users()
    {
        return $this->hasMany(Book::class);
    }
}
