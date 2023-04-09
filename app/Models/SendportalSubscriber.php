<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SendportalSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
      'hash',
      'email',
      'first_name',
      'last_name',
      'meta',
      'unsubscribed_at',
      'unsubscribe_event_id'
  ];

  protected $casts = [
    // Add other casts if necessary
    'unsubscribed_at' => 'datetime',
];

      protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->hash = Uuid::uuid4()->toString();
                $model->workspace_id = 1;
            }
        );
    }

    public static function updateOrCreateSubscriber($data)
    {
    $email = $data['email'];
    unset($data['email']); // remove email key from $data array

    if(isset($data['name'])) {
    $name = self::splitName($data['name']);
    if(isset($name[0])) {
      $data['first_name'] = $name[0];
    }
    if(isset($name[1])) {
      $data['last_name'] = $name[1];
    }
  }

    $subscriber = self::updateOrCreate(
        ['email' => $email],
        $data
    );

    return $subscriber;
    }

    public static function splitName($name) {
      $name = trim($name); // remove leading and trailing whitespace
      $words = explode(' ', $name); // split the string into words using space as delimiter
      $first_name = $words[0]; // the first word is the first name
      $last_name = (count($words) > 1) ? implode(' ', array_slice($words, 1)) : ''; // the remaining words (if any) are the last name
  
      return [$first_name, $last_name];
  }
      
}
