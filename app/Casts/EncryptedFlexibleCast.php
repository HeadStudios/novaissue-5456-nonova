<?php

namespace App\Casts;

use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class EncryptedFlexibleCast extends FlexibleCast
{
    /**
     * Fill the given attribute with the given data.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     * @param mixed $data
     * @param array $loading
     * @return mixed
     */
    public function fillAttributeFromData($model, $attribute, $data, $loading = [])
    {
        // Call the parent fillAttributeFromData method to get the default behavior
        $value = parent::fillAttributeFromData($model, $attribute, $data, $loading);

        // Loop through the layouts and modify the password field
        foreach ($value as $row) {
            if ($row->layout === 'code') {
                $attributes = $row->attributes;
                $attributes['password'] = 'CoopaPoopa'; //encrypt($attributes['password']); // modify the password field here
                $row->attributes = $attributes;
            }
        }

        // Return the modified value
        return $value;
    }
}
