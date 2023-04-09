<?php

namespace Acme\InlineRelatedField;

use Outl1ne\NovaInlineTextField\InlineText;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Log;


class InlineRelatedField extends InlineText
{
    /**
     * The relationship attribute on the parent model.
     *
     * @var string
     */
    protected $relationshipAttribute;

    /**
     * The attribute on the related model.
     *
     * @var string
     */
    protected $relatedModelAttribute;

    /**
     * Create a new inline related field.
     *
     * @param string $name
     * @param string $relationshipAttribute
     * @param string $relatedModelAttribute
     */
    public function __construct($name, $relationshipAttribute, $relatedModelAttribute)
    {
        parent::__construct($name);

        $this->relationshipAttribute = $relationshipAttribute;
        $this->relatedModelAttribute = $relatedModelAttribute;
    }

    /**
     * Resolve the field's value for display.
     *
     * @param mixed $resource
     * @param string|null $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        $relationship = $resource->{$this->relationshipAttribute};

        if ($relationship) {
            $this->value = $relationship->{$this->relatedModelAttribute};
        } else {
            $this->value = null;
        }
    }

    /**
     * Fill a value into the field and relationship.
     *
     * @param NovaRequest $request
     * @param $model
     * @param string $attribute
     * @param string|null $requestAttribute
     * @return void
     */
    public function fillInto(NovaRequest $request, $model, $attribute, $requestAttribute = null)
{
    $relatedModelClass = $this->relatedModelClass;
    $relatedModelInstance = $relatedModelClass::find($this->relatedModelId);
    
    if ($relatedModelInstance === null) {
        Log::error('Error: related model instance not found. Model class: ' . $relatedModelClass . ', Model ID: ' . $this->relatedModelId);
        throw new \Exception('Related model instance not found.');
    }

    $relatedModelInstance->{$this->relatedModelAttribute} = $request[$attribute];
    $relatedModelInstance->save();
}
}