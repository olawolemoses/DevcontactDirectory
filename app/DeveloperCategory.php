<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeveloperCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'developer_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function contact() {
        return $this->belongsTo('App\DeveloperContact', 'developer_id');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
