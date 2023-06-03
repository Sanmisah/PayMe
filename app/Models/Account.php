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
use Carbon\Carbon;


class Account extends Model
{

    use HasFactory;
    protected $fillable = [
        'area_id',
        'account_no',
        'name',
        'mobile_no',
        'alternative_no',
        'email',
        'contact_person',
        'contact_person_no',
        'contact_person_email',
        'address',
    ];

    public function Area(){
        return $this->belongsTo(Area::class);
    }

    
}