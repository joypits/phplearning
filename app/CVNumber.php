<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CVNumber extends Authenticatable
{
    
    protected $table = 'tbl_cv_number';
    protected $fillable = ['id','employee_number','cv_number','amount','loan_type'];

    public $timestamps = false;
}
