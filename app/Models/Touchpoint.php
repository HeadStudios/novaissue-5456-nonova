<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Touchpoint extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'date',
        // Add any other attributes that should be fillable
    ];

    public function contact()
        {
            // Use the 'air_contact_id' field to find the matching contact
            return $this->belongsTo(Contact::class, 'air_contact_id', 'air_id');
        }

    

}
