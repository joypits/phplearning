<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Billing extends Authenticatable
{
    
    protected $table = 'billing';
    protected $fillable = ['id','employee_number','amount_paid','name','cv_number','amount_paid','loan_type','amount_loan','monthly_dues','billing_amount','interest_amount','date_loan','due_date','true_false','advance_payment','billing_number'];

    public $timestamps = false;
}
