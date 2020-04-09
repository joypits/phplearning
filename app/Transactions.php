<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'oppf.tbl_transactions';
    protected $fillable = ['cv_number','employee_number','debit','loan_type','loan_duration','date_interest'];
    
    protected $connection = 'mysql2';

    public $timestamps = false;
}
