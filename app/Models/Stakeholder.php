<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'position', 'mobile', 'responsibility'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_air_id', 'air_id');
    }
}