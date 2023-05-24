<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LoanRepayment;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_repayment_id',
        'payment_id',
        'travelling_charges',
        'interest_received_amount',
        'loan_received_amount',
        'payment_mode',
        'utr_no'
    ];

    public function LoanRepayments(){
        return $this->belongsTo(LoanRepayment::class);
    }
}