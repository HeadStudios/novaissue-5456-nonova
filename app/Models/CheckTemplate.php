<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class CheckTemplate extends Model
{
    use HasFactory;

    public $table = 'check_templates';

    protected $casts = [
        'check_template' => FlexibleCast::class
    ];

}
