<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'pay_term', 'opening_cl', 'opening_sl', 'opening_pl', 'consumed_cl',
        'consumed_sl', 'consumed_pl', 'closing_cl', 'closing_sl', 'closing_pl'];

}
