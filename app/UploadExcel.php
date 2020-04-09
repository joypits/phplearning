<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UploadExcel extends Authenticatable
{
    
    protected $table = 'tbl_uploads';
    protected $fillable = ['id','employee_number','name','cv_number','amount','loan_type'];

    public $timestamps = false;
}
