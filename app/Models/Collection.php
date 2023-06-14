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
use Carbon\Carbon;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_repayment_id',
        'payment_date',
        'travelling_charges',
        'interest_received_amount',
        'loan_received_amount',
        'payment_mode',
        'utr_no',
        'total_amount'
    ];

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = $value != null ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }  
   

    public function getPaymentDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }


    public function LoanRepayment(){
        return $this->belongsTo(LoanRepayment::class);
    }
}