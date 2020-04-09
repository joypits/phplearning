<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UploadExcel2 extends Authenticatable
{
    
    protected $table = 'tbl_uploads2';
    protected $fillable = ['id','cv_number','employee_number','name','amount','loan_type','date_loan','terms','particulars'];

    public $timestamps = false;
}
