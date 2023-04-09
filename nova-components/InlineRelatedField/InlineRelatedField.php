<?php

namespace App\Nova\Fields;

use Outl1ne\NovaInlineTextField\InlineText;
use Laravel\Nova\Http\Requests\NovaRequest;

class InlineRelatedField extends InlineText
{
    public function __construct($name, $relatedModel, $relatedColumn)
    {
        parent::__construct($name);

        $this->displayUsing(function ($value, $resource) use ($relatedModel, $relatedColumn) {
            if ($resource->{$relatedModel} && $resource->{$relatedModel}->{$relatedColumn}) {
                return $resource->{$relatedModel}->{$relatedColumn};
            } else {
                return '';
            }
        });

        $this->fillUsing(function ($request, $model, $attribute, $requestAttribute) use ($relatedModel, $relatedColumn) {
            if ($request->exists($requestAttribute)) {
                $model->{$relatedModel}->{$relatedColumn} = $request[$requestAttribute];
                $model->{$relatedModel}->save();
            }
        });
    }
}