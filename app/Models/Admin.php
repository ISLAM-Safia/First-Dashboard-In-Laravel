<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,  Notifiable;
//HasRoles,
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        // 'password',
    ];

    // public function getActiveKeyAttribute()
    // {
    //     return $this->active ? 'Active' : 'In-Active';
    // }

    public function userName(): Attribute
    {
        return new Attribute(get: fn () => $this->name);
    }

    public function activeKey(): Attribute
    {
        return new Attribute(get: fn () => $this->active ? 'Active' : 'In-Active');
    }

    public function genderKey(): Attribute
    {
        return new Attribute(get: fn () => $this->gender == 'M' ? 'Male' : 'Female');
    }
}

// <!-- <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// // use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;

// class Admin extends Authenticatable
// {
//     use HasFactory;
//     // protected $guard = 'admin';
// } -->
