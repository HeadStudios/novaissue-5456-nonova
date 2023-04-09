<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class Sequencer extends Model
{
    use HasFactory;

    protected $table = 'sequencer';

    protected $casts = [
       
        'sequence' => FlexibleCast::class

    ];

    public function getPropsCollection(): Collection
    {
         return new Collection(
              isset($this->attributes['sequence']) 
              ? json_decode($this->attributes['sequence'], false) 
              : []
         );
    }
    
    public function getPermalinkAttribute()
    {
        return Str::slug($this->name, '-');
    }
    
    public function setPropsCollection(Collection $products): void
    {
         $this->attributes['sequence'] = $products->toJson();
    }

}
