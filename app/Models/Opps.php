<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Illuminate\Support\Collection;
use App\Models\Contact;

class Opps extends Model
{
    use HasFactory;

    protected $table = 'opps';

    protected $casts = [
        'Schedule' => 'array',
        'products' => FlexibleCast::class,
        'stakeholders' => FlexibleCast::class,
        'schedule' => FlexibleCast::class,
        'terms' => FlexibleCast::class,
        'date' => 'date'
    ];



public function getScheduleCollection(): Collection
{
     return new Collection(
          isset($this->attributes['schedule']) 
          ? json_decode($this->attributes['schedule'], false) 
          : []
     );
}

public function contact()
{
     return $this->belongsTo(Contact::class, 'contact_air_id', 'air_id');
}

public function setScheduleCollection(Collection $products): void
{

     
     $this->attributes['schedule'] = $products->toJson();
     //$this->attributes['schedule'] = "NOOOOOO!";
}

public function getProductsCollection(): Collection
{
     return new Collection(
          isset($this->attributes['products']) 
          ? json_decode($this->attributes['products'], false) 
          : []
     );
}

public function setProductsCollection(Collection $products): void
{
     $this->attributes['products'] = $products->toJson();
}

public function getStakeholdersCollection(): Collection
{
     return new Collection(
          isset($this->attributes['stakeholders']) 
          ? json_decode($this->attributes['stakeholders'], false) 
          : []
     );
}

public function setStakeholdersCollection(Collection $products): void
{
     $this->attributes['stakeholders'] = $products->toJson();
}


public function getExecSummAttribute()
{
     $copy = $this->attributes['exec_summary'];
    $company_name = $this->attributes['company'];
    $copy = str_replace('{{company}}', $company_name, $copy);
    return $copy;
}
    
}
