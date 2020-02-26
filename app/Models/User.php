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

    protected $appends = ['role_name'];
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

    public function getRoleNameAttribute()
    {
        $role_name = $this->role->name;
        return $role_name;
    }
    protected $hidden = [
        'password', 'remember_token',
    ];
}
