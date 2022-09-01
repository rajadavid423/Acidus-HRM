<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'month', 'gross', 'working_days', 'days_present', 'basic',
        'hra', 'special_day_allowance', 'special_allowance', 'shift_allowance', 'other_allowance', 'total_earnings', 'epf', 'esi', 'tds_deduction', 'other_deduction',
        'medi_claim', 'total_deduction', 'net_salary', 'company_epf', 'company_esi', 'bank_name', 'account_number', 'ifsc_code', 'comments'];

    public function userDetail()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
