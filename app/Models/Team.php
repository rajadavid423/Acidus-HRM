<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable=['team_name','description','responsible_person'];

    public function setResponsiblePersonAttribute($value)
    {
        $this->attributes['responsible_person'] = $value ? json_encode($value) : "";
    }

    public function getResponsiblePersonAttribute($value)
    {
        return $value ? json_decode($value) : "";
    }
}
