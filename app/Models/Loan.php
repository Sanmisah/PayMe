<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use App\Http\Models\Area;
use App\Http\Models\Agent;

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
        'address'
    ];

    public function Area(){
        return $this->belongsTo(Area::class);
    }

    public function Agent(){
        return $this->belongsTo(Agent::class);
    }
}