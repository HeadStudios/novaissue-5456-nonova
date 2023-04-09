<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Opps;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ScheduledSms;



class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','mobile','unsubscribed', 'website', 'account', 'sentiment'];

    public static $searchable = true;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            $contact->air_id = 'rec' . Str::random(16);
        });
    }

    public static function search(\Laravel\Nova\Http\Requests\NovaRequest $request, $query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public static function updateOrCreateContact($data)
    {
    $email = $data['email'];
    unset($data['email']); // remove email key from $data array

    $contact = self::updateOrCreate(
        ['email' => $email],
        $data
    );

    return $contact;
    }

    public function touchpoints()
    {
        // Use the 'air_id' field to find the matching touchpoints
        return $this->hasMany(Touchpoint::class, 'air_contact_id', 'air_id');
    }

    public function opps()
{
    return $this->hasMany(Opps::class, 'contact_air_id', 'air_id');
}

    public function campaign_contacts() {
        return $this->belongsToMany(CampaignContact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unsubscribe()
    {
        $this->attributes['unsubscribed'] = 1;
        
    }

    public function audit()
    {
        return $this->belongsTo(VideoAudit::class, 'air_id', 'contact_id');
    }

    public function scheduledEmails(): HasMany
{
    return $this->hasMany(ScheduledEmail::class, 'contact_id');
}

        public function scheduledSms(): HasMany
        {
            return $this->hasMany(ScheduledSms::class, 'contact_air_id', 'air_id');
        }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class, 'contact_air_id', 'air_id');
    }

    public function displayStakeholderNames()
{
    $names = '';
    foreach ($this->stakeholders as $stakeholder) {
        $names .= $stakeholder->name . ', ';
    }
    return rtrim($names, ', ');
}

}
