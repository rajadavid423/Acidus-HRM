<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'designation_id', 'employee_id', 'shift_id', 'dob', 'process_id',
        'gender', 'team_id', 'client_id', 'branch_id', 'phone_number', 'aadhar_number', 'esi_number', 'uan_number', 'date_of_joining',
        'date_of_leaving', 'cl', 'sl', 'pl', 'salary', 'gross', 'basic', 'hra', 'esi', 'pf', 'insurance', 'net_amount',
        'bank_id', 'account_number', 'ifsc'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = $value ? Carbon::parse($value)->format('Y-m-d') : NULL;
    }

    public function setDateOfJoiningAttribute($value)
    {
        $this->attributes['date_of_joining'] = $value ? Carbon::parse($value)->format('Y-m-d') : today()->format('Y-m-d');
    }

    public function setDateOfLeavingAttribute($value)
    {
        $this->attributes['date_of_leaving'] = $value ? Carbon::parse($value)->format('Y-m-d') : NULL;
    }

    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }

    public function shift()
    {
        return $this->hasOne(Shift::class, 'id', 'shift_id');
    }

    public function process()
    {
        return $this->hasOne(Process::class, 'id', 'process_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }


    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }
}
