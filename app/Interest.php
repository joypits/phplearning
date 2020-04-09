<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Interest extends Authenticatable
{
    
    protected $table = 'tbl_interest';
    protected $fillable = ['id','employee_number','payee','cv_number','amount','loan_type','year'];

    public $timestamps = false;
}
