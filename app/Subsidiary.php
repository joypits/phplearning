<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $table = 'oppf.tbl_subsidiary';
    protected $fillable = ['cv_number','employee_number','debit','loan_type'];
    
    protected $connection = 'mysql2';

    public $timestamps = false;
}
