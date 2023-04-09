<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalMerge extends Model
{
    use HasFactory;
    protected $table = 'global_merge';
    protected $fillable = ['name', 'description', 'value'];
}
