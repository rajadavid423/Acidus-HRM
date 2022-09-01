<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPercentage extends Model
{
    use HasFactory;

    protected $fillable = ['basic', 'hra', 'esi', 'pf', 'company_esi', 'company_pf'];
}
