<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForTestingOnly extends Model
{
    protected $table = 'oppf.tbl_test';
    protected $fillable = ['cv_number','employee_number','amount_loan','loan_type'];
    
    protected $connection = 'mysql2';

    public $timestamps = false;
}
