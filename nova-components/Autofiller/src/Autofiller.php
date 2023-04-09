<?php

namespace Kostasmatrix\Autofiller;

use Laravel\Nova\Fields\Field;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Autofiller extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'autofiller';

    public function max($value) {

        $campaigns = Campaign::where('template', 1)->get();

        $carray = $campaigns->toArray();

        $user = User::where('id', Auth::id())->get();
        $user = $user->toArray();
        $user[0]['company_logo'] = Storage::disk('s3')->url($user[0]['company_logo']);

        return $this->withMeta(['maxLength' => $value, 'minLength' => 169, 'bigLength' => 269, 'modelworld' => $carray, 'player' => $user, 'selector' => collect([
            ['text' => 'Template 1', 'id'=>0, 'value' => ['tiktok_url' => 'Tik Tok Template 1', 'headline' => 'Headline Template 1', 'mms_msg' => 'MMS Template Message 1']],
            ['text' => 'Tempalte 2', 'id'=>1, 'value' => ['tiktok_url' => 'Tik Tok Template 2', 'headline' => 'Headline Template 2', 'mms_msg' => 'MMS Template Message 2']],
            ['text' => 'Template 3', 'id'=>2, 'value' => ['tiktok_url' => 'Tik Tok Template 3', 'headline' => 'Headline Template 3', 'mms_msg' => 'MMS Template Message 3']]
            ])]);
    }

}
