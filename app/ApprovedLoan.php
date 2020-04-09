<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovedLoan extends Model
{
    protected $table = 'oppf.tbl_loan_approved';
    protected $fillable = ['cv_number','employee_number','amount','loan_type'];
    
    protected $connection = 'mysql2';

    public $timestamps = false;
}
