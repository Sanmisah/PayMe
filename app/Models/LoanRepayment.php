<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Models\Area;
use App\Models\Loan;
use App\Models\Collection;
use Carbon\Carbon;

class LoanRepayment extends Model
{

    use HasFactory;
    protected $fillable = [
        'loan_id',
        'payment_date',
        'interest_amount',
        'repayment_amount',
        'paid_amount',
        'log'
    ];

    public function Loan(){
        return $this->belongsTo(Loan::class);
    }

    public function setPaymentDate($value)
    {
        $this->attributes['payment_date'] = $value != null ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    public function getPaymentDate($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function Collection()
    {
        return $this->hasMany(Collection::class);
    }

    public function balance_amount()
    {
        return $this->interest_amount - $this->paid_amount;
    }
    
}