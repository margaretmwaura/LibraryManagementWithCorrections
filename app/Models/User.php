<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('due_date', 'borrow_date','order_date','return_date')->withTimestamps();
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}
