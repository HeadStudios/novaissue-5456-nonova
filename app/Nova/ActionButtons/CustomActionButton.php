<?php
namespace App\Nova\ActionButtons;

use Laravel\Nova\Actions\Action;
use Pavloniym\ActionButtons\ActionButton as BaseActionButton;
use Laravel\Nova\Fields\Hidden;

class CustomActionButton extends BaseActionButton
{
    protected $resourceId;

    public function action(Action $action, $resourceId): CustomActionButton
    {
        $this->action = $action;
        $this->resourceId = $resourceId;
        return $this;
    }

    public function fields()
    {
        return [           
            Hidden::make('touchpoint_id')->default($this->resourceId),
        ];
    }
}