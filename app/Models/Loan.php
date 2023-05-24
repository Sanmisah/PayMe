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
use App\Models\User;

class Loan extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'mobile_no',
        'alternative_no',
        'email',
        'contact_person',
        'contact_person_no',
        'contact_person_email',
        'agent_id',
        'area_id',
        'address',
        'loan_no',
        'loan_date',
        'loan_amount',
        'interest_rate',
        'period',
        'emi_day'
    ];

    public function Area(){
        return $this->belongsTo(Area::class);
    }

    public function Agent(){
        return $this->belongsTo(User::class);
    }

    public function LoanRepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function setLoanDate($value)
    {
        $this->attributes['loan_date'] = $value != null ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    public function getLoanDate($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public static function booted() :void 
    {
        static::creating(function(Loan $loan){
            $loans = Loan::orderBy('created_at', 'DESC')->first();
            $max = ($loans) ? Str::substr($loans->loan_no, -1) : 0;
            $loan->loan_no = 'L'.str_pad($max + 1,5,0, STR_PAD_LEFT);
        });
    }

  
}