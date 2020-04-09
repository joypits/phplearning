<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Comp2 extends Authenticatable
{
    
    protected $table = 'tbl_comp2';
    protected $fillable = ['id','employee_number','lname','fname','amount','loan_type'];

    public $timestamps = false;
}
