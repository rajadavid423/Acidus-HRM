<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'start_date', 'end_date', 'duration', 'leave_type', 'no_of_days', 'reason', 'status', 'reject_reason', 'paid_leave_count', 'loss_of_pay_count'];

    public function userDetail()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
