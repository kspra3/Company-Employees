<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }

    public function getFullNameAttribute() 
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
        
}
