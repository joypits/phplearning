<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Comp1 extends Authenticatable
{
    
    protected $table = 'tbl_comp1';
    protected $fillable = ['id','employee_number','cv_number','name','amount','loan_type'];

    public $timestamps = false;
}
