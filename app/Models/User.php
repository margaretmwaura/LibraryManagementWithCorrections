<?php

namespace App\Models;

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
        return $this->belongsToMany(Book::class)->withPivot('due_date', 'borrow_date','reserve_date','return_date','status','deleted_at')->withTimestamps();
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}
