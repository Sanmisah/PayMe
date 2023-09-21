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
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;


class Loan extends Model
{

    use HasFactory;
    protected $fillable = [
        'account_id',
        'agent_id',
        'loan_no',
        'loan_date',
        'loan_amount',
        'final_amount',
        'interest_rate',
        'period',
        'emi_day'
    ];

    public function Account(){
        return $this->belongsTo(Account::class);
    }

       public function Agent(){
        return $this->belongsTo(User::class);
    }

    public function LoanRepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function setLoanDateAttribute($value)
    {
        $this->attributes['loan_date'] = $value != null ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    public function getLoanDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function balanceAmount()
    {
        return $this->final_amount - $this->paid_amount;
    }

    public static function booted() :void 
    {
        static::creating(function(Loan $loan){
            $loans = Loan::orderBy('created_at', 'DESC')->first();
            $max = ($loans) ? Str::substr($loans->loan_no, -1) : 0;
            $loan->loan_no = 'L'.str_pad($max + 1,5,0, STR_PAD_LEFT);
        });

        static::deleting(function(Loan $loan)
        {
            if ($laon->forceDeleting) {
                $loan->LoanRepayments()->detach();
            }
        });
    }

   

  
}