<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevelopersContact extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'cat', 'lastname', 'email', 'phoneno', 'github', 'country'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
