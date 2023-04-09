<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorInsight extends Model
{
    use HasFactory;

    protected $table = 'investor_insight';

    protected $casts = [
        'lease_renewal_date' => 'date'
    ];


    

}
