<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaInlineTextField\InlineText;
use Outl1ne\MultiselectField\Multiselect;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Illuminate\Support\HtmlString;

use Acme\InlineRelatedField\InlineRelatedField;
use App\Nova\Actions\OppHit; // Make sure this points to the
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Nova\Actions\SMSDominion;
use App\Nova\Actions\SendSequence;
use App\Modles\Opps;
use KirschbaumDevelopment\Nova\InlineSelect;
use Laravel\Nova\Fields\Textarea;
use Pavloniym\ActionButtons\ActionButton;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use App\Nova\ActionButtons\CustomActionButton;



class Touchpoint extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Touchpoints>
     */
    public static $model = \App\Models\Touchpoint::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('contact.touchpoints');
    }

    public static function availableForNavigation(Request $request)
    {
        //return !Gate::check('hide-resource-from-students', $request->user());
        return $request->user()->hasRole('admin');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        return [
            BelongsTo::make('Contact')->searchable()->nullable(true)->sortable(),
            Date::make('Date')->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : '')->nullable(true),
            Text::make('Mobile', function () {
                if ($this->contact) {
                    $style = '';
                    if (!empty($this->call_result)) {
                        $style = '<style>[dusk="'.$this->id.'-row"] { background-color: #defadc; }</style>';
                    }
            
                    // Concatenate the country_code and mobile columns without any spaces
                    $formattedNumber = $this->contact->country_code . $this->contact->mobile;
                    
                    return '<a class="link-default" href="tel:' . $formattedNumber . '">' . $formattedNumber . '</a>' . $style;
                } else {
                    return '';
                }
            })->asHtml()->nullable(true),            
            /*Text::make('Website', function () {
                if ($this->contact && $this->contact->website) {
                    return substr($this->contact->website, 0, 45);
                } else {
                    return '';
                }
            })->asHtml()->nullable(true),*/
            InlineText::make('Website', 'contact.website')->nullable(true)->onlyOnIndex(),
            InlineText::make('Email', 'contact.email')->nullable(true)->onlyOnIndex(),
            /*Text::make('Email', function () {
                if ($this->contact && $this->contact->email) {
                    return substr($this->contact->email, 0, 40);
                } else {
                    return '';
                }
            })->asHtml()->nullable(true), */
            Text::make('Account', function () {
                if ($this->contact && $this->contact->account) {
                    return $this->contact->account;
                } else {
                    return '';
                }
            })->asHtml()->nullable(true),
            Text::make('City', function () {
                if ($this->contact && $this->contact->city) {
                    return substr($this->contact->city, 0, 45);
                } else {
                    return '';
                }
            })->asHtml()->nullable(true),
            Text::make('Adudit', function () {
                if(isset($this->contact->audit)) {
                    return '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.1" fill-rule="evenodd" clip-rule="evenodd" d="M12 17C15.866 17 19 13.866 19 10C19 6.13401 15.866 3 12 3C8.13401 3 5 6.13401 5 10C5 13.866 8.13401 17 12 17ZM12 6.75C10.2051 6.75 8.75 8.20507 8.75 10C8.75 11.7949 10.2051 13.25 12 13.25C13.7949 13.25 15.25 11.7949 15.25 10C15.25 8.20507 13.7949 6.75 12 6.75Z" fill="#000000"/>
                    <path d="M19 10C19 13.866 15.866 17 12 17C8.13401 17 5 13.866 5 10C5 6.13401 8.13401 3 12 3C15.866 3 19 6.13401 19 10Z" stroke="#000000" stroke-width="2"/>
                    <path d="M15 10C15 11.6569 13.6569 13 12 13C10.3431 13 9 11.6569 9 10C9 8.34315 10.3431 7 12 7C13.6569 7 15 8.34315 15 10Z" stroke="#000000" stroke-width="2"/>
                    <path d="M15 17L16.5 19V19C17.118 19.824 16.5301 21 15.5 21H12H8.5C7.46994 21 6.88197 19.824 7.5 19V19L9 17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>';
                } else {
                    return '';
                }
            })->asHtml()->nullable(true),
            //Textarea::make('Notes')->nullable(true),
            Text::make('Rollup', function () {
                if (isset($this->contact->touchpoints)) {
                    $notes = $this->contact->touchpoints->sortBy('date')->pluck('notes')->implode('<br>');
                    $notes = preg_replace('/\n/', '<br>', $notes); // Replace \n with <br>
                    $notes = str_split($notes, 30); // Limit each line to 30 characters
                    $notes = implode('<br>', $notes);
                    return $notes;
                } else {
                    return "No Contact";
                }
            })->asHtml(),
            Text::make('Last Contact Date', function () {
                if ($this->contact) {
                    $lastTouchpoint = $this->contact->touchpoints()
                        ->where('call_result', '!=', 'Voicemail')
                        ->whereNotNull('call_result')
                        ->orderBy('date', 'desc')
                        ->first();
            
                    return $lastTouchpoint ? $lastTouchpoint->date->format('Y-m-d') : null;
                }
                return null;
            }),
            InlineText::make('Notes')->nullable(true),
            InlineSelect::make('Call Result', 'call_result')->options(function () {
                return [
                '' => '',
                'Not Interested' => 'Not Interested',
                'Voicemail' => 'Voicemail',
                'Call Me Back' => 'Call Me Back',
                'Disqualified' => 'Disqualified',
                'Wrong Number' => 'Wrong Number',
            ];
            })->default('')->sortable()->inlineOnIndex()->enableOneStepOnIndex(),

            Text::make('Opps', function () {
                if ($this->contact) {
                    $opp = $this->contact->opps->first();
                    return $opp ? "<a target='_blank' href='/nova/resources/opps/".$opp->id."'>".$opp->price."</a>" : null;
                }
                return null;
            })->asHtml()->sortable(),

            ActionButton::make('Nuclear') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#000000"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <path fill="#990000" d="M177.746 465.133a111.134 111.134 0 0 0 24.98 10.73 123.6 123.6 0 0 1-165.845-169.69c2.617 9.252 7.46 19.842 14.427 31.56 13.57 22.786 35.29 49.784 59.59 74.084 23.174 23.175 46.923 42.115 66.85 53.316zM317.31 21.616l-66.85 66.85 173.69 173.69 66.85-66.85zM259.29 162.62l89.473 89.474 44.895 5.958L254.095 118.49zm81.522 107.348c-15.575 34.527-65.865 141.216-108.848 184.222-37.728 37.73-206.412-143.08-174.746-174.746 42.772-42.772 149.977-91.478 185.478-106.866l97.342 97.343zM203.008 355.1a33.014 33.014 0 0 1-31.794-8.55l-24.77 24.77a68.022 68.022 0 0 0 65.56 17.663zm-40.24-40.472a33.014 33.014 0 0 1 23.457-23.34l-8.983-33.893a68.022 68.022 0 0 0-48.284 48.167zm41.86-1.43a14.238 14.238 0 1 0 0 20.136 14.238 14.238 0 0 0 0-20.196zm38.044-38.047l-24.77 24.77a33.014 33.014 0 0 1 8.503 31.96l33.847 9.16a68.022 68.022 0 0 0-17.592-65.947z"/> </g> </svg>')
            ->action(new Actions\GoNuclear, $this->resource->id)->hideWhenUpdating(),

            ActionButton::make('Sender') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="info-a" d="M10.5134277,0.293457031 C12.3116048,6.98051974 11.4737956,10.510549 8,10.8835449 C1.8918457,10.8835449 -0.0366210938,14.6247559 0.773681641,16.5002441 C1.58398438,18.3757324 4.12866211,19.8500977 6.21289062,20.2067871 C8.29711914,20.5634766 11.6750488,20.5915527 15.8925781,16.5002441 C20.1101074,12.4089355 17.1142578,5.80639648 15.8925781,4.07495117 C15.078125,2.9206543 13.2850749,1.66015625 10.5134277,0.293457031 Z"/><path id="info-c" d="M11,22 C4.92486775,22 0,17.0751322 0,11 C0,4.92486775 4.92486775,0 11,0 C17.0751322,0 22,4.92486775 22,11 C22,17.0751322 17.0751322,22 11,22 Z M11,20.24 C16.1031111,20.24 20.24,16.1031111 20.24,11 C20.24,5.89688891 16.1031111,1.76 11,1.76 C5.89688891,1.76 1.76,5.89688891 1.76,11 C1.76,16.1031111 5.89688891,20.24 11,20.24 Z M10,10 C10,9.44771525 10.4477153,9 11,9 C11.5522847,9 12,9.44771525 12,10 L12,15 C12,15.5522847 11.5522847,16 11,16 C10.4477153,16 10,15.5522847 10,15 L10,10 Z M11,8 C10.4477153,8 10,7.55228475 10,7 C10,6.44771525 10.4477153,6 11,6 C11.5522847,6 12,6.44771525 12,7 C12,7.55228475 11.5522847,8 11,8 Z"/></defs><g fill="none" fill-rule="evenodd" transform="translate(1 1)"><g transform="translate(3 1)"><mask id="info-b" fill="#ffffff"><use xlink:href="#info-a"/></mask>
<use fill="#D8D8D8" xlink:href="#info-a"/>
<g fill="#FFA0A0" mask="url(#info-b)">
<rect width="24" height="24" transform="translate(-4 -2)"/></g>
              </g>
              <mask id="info-d" fill="#ffffff">
                <use xlink:href="#info-c"/>
              </mask>
              <use fill="#000000" fill-rule="nonzero" xlink:href="#info-c"/>
              <g fill="#7600FF" mask="url(#info-d)">
                <rect width="24" height="24" transform="translate(-1 -1)"/>
              </g>
            </g>
          </svg>')
            ->action(new Actions\SendEmailAction, $this->resource->id)->hideWhenUpdating(),

            ActionButton::make('Opp') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <path d="M182.52 146.2h585.14v256h73.15V73.06H109.38v877.71h256v-73.14H182.52z" fill="#293324"/> <path d="M255.67 219.34h438.86v73.14H255.67zM255.67 365.63h365.71v73.14H255.67zM255.67 511.91H475.1v73.14H255.67zM775.22 458.24L439.04 794.42l-0.52 154.64 155.68 0.52L930.38 613.4 775.22 458.24z m51.72 155.16l-25.43 25.43-51.73-51.72 25.44-25.44 51.72 51.73z m-77.14 77.15L620.58 819.77l-51.72-51.72 129.22-129.22 51.72 51.72zM511.91 876.16l0.17-51.34 5.06-5.06 51.72 51.72-4.85 4.85-52.1-0.17z" fill="#293324"/> </g> </svg>')
            ->action(new Actions\OppHit(57), $this->resource->id)
            ->hideWhenUpdating(),

            ActionButton::make('BDM Land') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M975.694 732.148a8.01 8.01 0 0 1-7.872-6.606l-55.552-314.98a7.992 7.992 0 0 1 6.482-9.262c4.31-0.906 8.496 2.14 9.26 6.482l55.554 314.98a7.968 7.968 0 0 1-6.482 9.26 6.912 6.912 0 0 1-1.39 0.126zM984.004 779.408a7.98 7.98 0 0 1-7.858-6.606c-7.2-40.826-163.534-48.322-260.396-43.48-4.436 0.454-8.152-3.17-8.372-7.574a7.988 7.988 0 0 1 7.59-8.386c27.036-1.39 264.942-11.322 276.922 56.662a7.994 7.994 0 0 1-7.886 9.384z" fill="" /><path d="M676.458 508.846a7.98 7.98 0 0 1-7.858-6.608 7.992 7.992 0 0 1 6.482-9.26c67.906-11.996 241.388-58.646 228.864-129.676a7.97 7.97 0 0 1 6.482-9.262c4.326-0.922 8.512 2.14 9.26 6.482 7.686 43.526-31.516 81.804-116.476 113.776-60.91 22.928-124.724 34.312-125.35 34.422a7.106 7.106 0 0 1-1.404 0.126z" fill="" /><path d="M911.816 369.908a8.01 8.01 0 0 1-7.872-6.606 7.97 7.97 0 0 1 6.482-9.262l31.484-5.544c4.326-0.874 8.496 2.14 9.262 6.482a7.97 7.97 0 0 1-6.48 9.262l-31.486 5.542a7.048 7.048 0 0 1-1.39 0.126z" fill="" /><path d="M1015.52 773.85a8.01 8.01 0 0 1-7.872-6.608l-72.216-409.484a7.97 7.97 0 0 1 6.48-9.262c4.326-0.874 8.496 2.14 9.262 6.482l72.216 409.484a7.97 7.97 0 0 1-6.48 9.262 7.06 7.06 0 0 1-1.39 0.126z" fill="" /><path d="M984.004 779.408a7.98 7.98 0 0 1-7.858-6.606 8.002 8.002 0 0 1 6.482-9.262l31.5-5.56c4.358-0.876 8.496 2.14 9.262 6.482a7.978 7.978 0 0 1-6.48 9.262l-31.502 5.56a7.256 7.256 0 0 1-1.404 0.124zM557.854 757.106a7.98 7.98 0 0 1-7.856-6.606l-38.888-220.492a7.976 7.976 0 0 1 6.482-9.262l157.49-27.768c4.294-0.86 8.496 2.138 9.262 6.48a7.992 7.992 0 0 1-6.482 9.262l-149.62 26.376 36.11 204.752 149.62-26.378c4.358-0.89 8.496 2.138 9.26 6.48a7.992 7.992 0 0 1-6.48 9.262L559.26 756.98a7.112 7.112 0 0 1-1.406 0.126z" fill="" /><path d="M557.87 757.106c-0.544 0-1.092-0.062-1.638-0.17l-84.298-17.618a7.992 7.992 0 0 1-6.24-6.436l-27.784-157.49a8 8 0 0 1 3.654-8.184l73.202-45.384a7.998 7.998 0 0 1 12.086 5.402l38.89 220.494a8.032 8.032 0 0 1-2.296 7.136 8.08 8.08 0 0 1-5.576 2.25z m-77.37-32.328l67.454 14.088-34.796-197.222-58.56 36.294 25.902 146.84zM709.786 697.852a7.976 7.976 0 0 1-7.856-6.606L674.16 533.74a7.992 7.992 0 0 1 6.48-9.262c4.312-0.86 8.496 2.138 9.262 6.482l27.77 157.506a7.99 7.99 0 0 1-6.482 9.26 7.092 7.092 0 0 1-1.404 0.126z" fill="" /><path d="M482.834 607.958a7.996 7.996 0 0 1-7.864-6.608 7.98 7.98 0 0 1 6.48-9.262l15.758-2.78c4.358-0.89 8.496 2.14 9.26 6.48a7.98 7.98 0 0 1-6.48 9.262l-15.758 2.782a7.052 7.052 0 0 1-1.396 0.126zM499.498 702.446a7.996 7.996 0 0 1-7.864-6.608 7.988 7.988 0 0 1 6.48-9.262l15.744-2.78c4.356-0.906 8.498 2.138 9.262 6.48a7.99 7.99 0 0 1-6.482 9.262l-15.742 2.782a7.086 7.086 0 0 1-1.398 0.126zM491.158 655.184a8.008 8.008 0 0 1-7.872-6.622 7.996 7.996 0 0 1 6.496-9.246l15.758-2.764c4.35-0.86 8.49 2.138 9.26 6.496a7.996 7.996 0 0 1-6.496 9.246l-15.758 2.764a6.96 6.96 0 0 1-1.388 0.126zM533.334 525.962a8.002 8.002 0 0 1-7.872-6.608 7.984 7.984 0 0 1 6.48-9.26l31.502-5.56c4.294-0.89 8.496 2.138 9.262 6.48a8 8 0 0 1-6.482 9.262l-31.5 5.56a6.9 6.9 0 0 1-1.39 0.126zM772.756 962.808a8.006 8.006 0 0 1-7.154-4.402l-74.996-149.168a7.966 7.966 0 0 1 3.544-10.728 7.954 7.954 0 0 1 10.73 3.544l75.028 149.166a8.01 8.01 0 0 1-3.56 10.728 7.79 7.79 0 0 1-3.592 0.86zM694.012 976.694a8 8 0 0 1-7.154-4.404l-74.996-149.166a7.964 7.964 0 0 1 3.544-10.728c3.966-2.032 8.762-0.39 10.728 3.544l75.03 149.166a8.01 8.01 0 0 1-3.562 10.728 7.78 7.78 0 0 1-3.59 0.86z" fill="" /><path d="M678.268 979.472a8.01 8.01 0 0 1-7.872-6.606 7.97 7.97 0 0 1 6.482-9.262l110.246-19.444c4.324-0.86 8.496 2.138 9.262 6.48a7.994 7.994 0 0 1-6.482 9.262l-110.246 19.444a6.912 6.912 0 0 1-1.39 0.126zM581.938 801.586a8.006 8.006 0 0 1-7.872-6.606l-3.124-17.726a7.97 7.97 0 0 1 6.482-9.262c4.358-0.906 8.496 2.14 9.26 6.48l3.124 17.726a7.97 7.97 0 0 1-6.482 9.262 7.028 7.028 0 0 1-1.388 0.126z" fill="" /><path d="M581.938 801.586a7.984 7.984 0 0 1-7.872-6.636 8.006 8.006 0 0 1 6.512-9.246L722.42 761.2c4.326-0.766 8.48 2.17 9.228 6.528a8.006 8.006 0 0 1-6.512 9.246l-141.842 24.504a8.26 8.26 0 0 1-1.356 0.108z" fill="" /><path d="M723.778 777.082a8.012 8.012 0 0 1-7.872-6.606l-2.78-15.76a7.97 7.97 0 0 1 6.482-9.262c4.292-0.874 8.496 2.14 9.26 6.482l2.78 15.758a7.97 7.97 0 0 1-6.48 9.262 7.06 7.06 0 0 1-1.39 0.126zM40.692 76.512c-4.412 0-8.074-3.576-8.074-7.996s3.498-7.996 7.918-7.996h0.156c4.42 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.996 7.996zM72.678 76.512c-4.412 0-8.074-3.576-8.074-7.996s3.498-7.996 7.918-7.996h0.156c4.42 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.996 7.996zM104.664 76.512c-4.412 0-8.074-3.576-8.074-7.996s3.498-7.996 7.918-7.996h0.156c4.42 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.996 7.996z" fill="" /><path d="M1015.77 92.504H8.23a7.99 7.99 0 0 1-7.996-7.996v-15.992c0-13.228 10.76-23.988 23.988-23.988h975.554c13.226 0 23.988 10.76 23.988 23.988v15.992a7.988 7.988 0 0 1-7.994 7.996zM16.226 76.512h991.546v-7.996a8.012 8.012 0 0 0-7.996-7.996H24.222a8.006 8.006 0 0 0-7.996 7.996v7.996z" fill="" /><path d="M1015.77 476.314a7.992 7.992 0 0 1-7.996-7.998V84.508c0-4.42 3.576-7.996 7.996-7.996s7.996 3.576 7.996 7.996v383.808a7.992 7.992 0 0 1-7.996 7.998zM8.23 732.196A7.99 7.99 0 0 1 0.234 724.2V84.508c0-4.42 3.576-7.996 7.996-7.996s7.996 3.576 7.996 7.996V724.2a7.99 7.99 0 0 1-7.996 7.996z" fill="" /><path d="M424.042 732.196H8.23c-4.42 0-7.996-3.576-7.996-7.996s3.576-7.996 7.996-7.996H424.04c4.418 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.994 7.996zM296.108 508.298a8 8 0 0 1-6.866-3.888l-41.122-68.532-41.12 68.532a7.97 7.97 0 0 1-10.972 2.748 7.982 7.982 0 0 1-2.74-10.962l47.978-79.962c2.89-4.842 10.824-4.842 13.712 0l47.978 79.962a7.986 7.986 0 0 1-2.74 10.962 7.892 7.892 0 0 1-4.108 1.14z" fill="" /><path d="M152.156 508.298a7.992 7.992 0 0 1-6.644-12.432l31.986-47.978a8.02 8.02 0 0 1 6.654-3.56c2.678 0 5.17 1.344 6.652 3.56l10.644 15.976a8 8 0 0 1-2.218 11.09c-3.694 2.42-8.652 1.438-11.088-2.218l-3.99-5.996-25.332 37.998a7.992 7.992 0 0 1-6.664 3.56z" fill="" /><path d="M951.798 300.394H72.202a7.99 7.99 0 0 1-7.996-7.996v-143.92a7.99 7.99 0 0 1 7.996-7.996H951.8a7.99 7.99 0 0 1 7.996 7.996v143.92a7.994 7.994 0 0 1-7.998 7.996z m-871.6-15.994h863.606V156.474H80.198V284.4z" fill="" /><path d="M328.084 524.292H72.202a7.99 7.99 0 0 1-7.996-7.996v-159.926a7.99 7.99 0 0 1 7.996-7.996h255.882a7.99 7.99 0 0 1 7.996 7.996v159.926a7.992 7.992 0 0 1-7.996 7.996z m-247.886-15.994h239.89v-143.934H80.198v143.934z" fill="" /><path d="M119.296 428.336c-13.228 0-23.988-10.762-23.988-23.99s10.76-23.988 23.988-23.988 23.99 10.76 23.99 23.988-10.76 23.99-23.99 23.99z m0-31.986c-4.412 0-7.996 3.592-7.996 7.996s3.584 7.998 7.996 7.998 7.996-3.594 7.996-7.998-3.584-7.996-7.996-7.996z" fill="" /><path d="M863.84 220.43H160.162c-4.42 0-7.998-3.576-7.998-7.996s3.578-7.996 7.998-7.996H863.84c4.418 0 7.996 3.576 7.996 7.996s-3.578 7.996-7.996 7.996z" fill="" /><path d="M767.882 252.416H256.118c-4.42 0-7.996-3.576-7.996-7.996s3.576-7.996 7.996-7.996h511.766c4.42 0 7.996 3.576 7.996 7.996s-3.578 7.996-7.998 7.996z" fill="" /><path d="M328.084 572.27H72.202c-4.42 0-7.996-3.576-7.996-7.996s3.576-7.996 7.996-7.996h255.882c4.42 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.996 7.996z" fill="" /><path d="M328.084 620.248H72.202a7.992 7.992 0 0 1-7.996-7.998 7.992 7.992 0 0 1 7.996-7.996h255.882a7.992 7.992 0 0 1 7.996 7.996 7.992 7.992 0 0 1-7.996 7.998z" fill="" /><path d="M200.142 668.226h-127.94c-4.42 0-7.996-3.578-7.996-7.998s3.576-7.996 7.996-7.996h127.942c4.42 0 7.996 3.576 7.996 7.996s-3.578 7.998-7.998 7.998z" fill="" /><path d="M535.988 481.638a7.99 7.99 0 0 1-6.856-12.102l31.984-53.302c2.89-4.842 10.824-4.842 13.712 0l19.242 32.062a8 8 0 0 1-2.732 10.964 8 8 0 0 1-10.98-2.75l-12.384-20.63-25.128 41.872a7.982 7.982 0 0 1-6.858 3.886z" fill="" /><path d="M472.01 508.298a7.992 7.992 0 0 1-6.646-12.432l31.986-47.978a8.02 8.02 0 0 1 6.654-3.56c2.678 0 5.17 1.344 6.652 3.56l10.644 15.976a8 8 0 0 1-2.218 11.09c-3.694 2.42-8.652 1.438-11.088-2.218l-3.99-5.996-25.332 37.998a7.988 7.988 0 0 1-6.662 3.56z" fill="" /><path d="M440.034 524.292h-47.978a7.99 7.99 0 0 1-7.996-7.996v-159.926a7.99 7.99 0 0 1 7.996-7.996h255.882a7.99 7.99 0 0 1 7.996 7.996v95.94c0 4.42-3.576 7.996-7.996 7.996s-7.996-3.576-7.996-7.996v-87.944H400.05v143.934h39.982c4.42 0 7.996 3.576 7.996 7.996s-3.574 7.996-7.994 7.996z" fill="" /><path d="M439.15 428.336c-13.228 0-23.988-10.762-23.988-23.99s10.76-23.988 23.988-23.988 23.99 10.76 23.99 23.988-10.762 23.99-23.99 23.99z m0-31.986c-4.412 0-7.996 3.592-7.996 7.996s3.584 7.998 7.996 7.998 7.996-3.594 7.996-7.998-3.584-7.996-7.996-7.996z" fill="" /><path d="M408.048 572.27h-15.994c-4.42 0-7.996-3.576-7.996-7.996s3.576-7.996 7.996-7.996h15.994c4.418 0 7.996 3.576 7.996 7.996s-3.578 7.996-7.996 7.996z" fill="" /><path d="M408.048 620.248h-15.994a7.992 7.992 0 0 1-7.996-7.998 7.992 7.992 0 0 1 7.996-7.996h15.994a7.994 7.994 0 0 1 7.996 7.996 7.992 7.992 0 0 1-7.996 7.998z" fill="" /><path d="M424.042 668.226h-31.986c-4.42 0-7.996-3.578-7.996-7.998s3.576-7.996 7.996-7.996h31.986c4.418 0 7.996 3.576 7.996 7.996s-3.578 7.998-7.996 7.998z" fill="" /><path d="M711.908 460.304a7.99 7.99 0 0 1-7.996-7.996v-95.94a7.99 7.99 0 0 1 7.996-7.996h159.928c4.42 0 7.996 3.576 7.996 7.996s-3.576 7.996-7.996 7.996h-151.932v87.944a7.99 7.99 0 0 1-7.996 7.996z" fill="" /><path d="M759.012 428.336c-13.228 0-23.988-10.762-23.988-23.99s10.76-23.988 23.988-23.988 23.988 10.76 23.988 23.988-10.76 23.99-23.988 23.99z m0-31.986c-4.404 0-7.996 3.592-7.996 7.996s3.592 7.998 7.996 7.998 7.996-3.594 7.996-7.998-3.592-7.996-7.996-7.996z" fill="" /></svg>')
            ->action(new Actions\CreateBDMLanding, $this->resource->id)->hideWhenUpdating(),

            ActionButton::make('Sequencer') // Name in resource table column
            ->icon('<svg fill="#000000" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 405.008 405.008" xml:space="preserve"> <g> <path d="M316.232,73.365l-50.75-50.75c-1.48-1.48-3.88-1.48-5.361,0l-78.268,78.269c-1.48,1.48-1.48,3.881,0,5.361l49.544,49.544 c-10.073-0.506-20.795-0.781-31.921-0.781c-56.835,0-103.2,7.126-105.696,16.066c-0.229,0.629-0.231,1.16-0.234,1.558v66.443 c0,1.382,1.116,2.499,2.499,2.499h3.567l71.358,99.28v61.657c0,1.379,1.118,2.497,2.496,2.497h52.022 c1.378,0,2.495-1.117,2.495-2.497v-61.653l63.015-86.811c0.579-0.792,0.634-1.841,0.16-2.693c-0.481-0.854-1.404-1.355-2.386-1.267 c-5.885,0.483-12.207,0.725-18.793,0.725c-22.639,0-44.844-2.903-58.057-5.027c7.463,0.101,17.541,0.206,28.188,0.206 c26.477,0,59.094-0.642,64.098-3.684c0.749-0.454,1.201-1.261,1.201-2.137l-0.003-67.545c-0.002-0.399-0.005-0.929-0.235-1.56 c-1.912-6.752-28.85-12.468-66.419-14.858l77.481-77.481C317.712,77.246,317.712,74.845,316.232,73.365z M273.098,173.885 c0,0-32.96,5.142-73.623,5.142c-40.661,0-73.623-5.142-73.623-5.142s32.962-5.145,73.623-5.145 C240.138,168.74,273.098,173.885,273.098,173.885z M266.064,42.732l-14.777,46.943c-0.356,1.132-1.243,2.019-2.376,2.375 l-46.942,14.776c-0.362,0.114-0.73,0.168-1.092,0.168c-1.545,0-2.978-0.992-3.466-2.544c-0.603-1.915,0.461-3.956,2.376-4.558 l45.135-14.208l14.209-45.136c0.603-1.914,2.642-2.979,4.559-2.375C265.603,38.777,266.666,40.818,266.064,42.732z"/> <path d="M139.363,126.419l30.961-30.961c0.903-0.903,0.903-2.367,0-3.271l-47.749-47.749c-0.903-0.903-2.367-0.903-3.271,0 l-30.961,30.96c-0.902,0.903-0.902,2.368,0,3.271l47.75,47.75C136.995,127.321,138.46,127.321,139.363,126.419z M127.964,85.349 l-9.016-28.638c-0.367-1.168,0.281-2.413,1.449-2.781c1.168-0.367,2.414,0.281,2.781,1.449l8.668,27.536l27.536,8.668 c1.168,0.368,1.816,1.612,1.449,2.78c-0.298,0.947-1.172,1.552-2.114,1.552c-0.221,0-0.445-0.033-0.667-0.103l-28.638-9.015 C128.723,86.58,128.182,86.039,127.964,85.349z"/> <path d="M176.615,60.809c0.664,0.664,1.741,0.664,2.405,0l35.129-35.128c0.664-0.664,0.664-1.742,0-2.406L191.371,0.498 c-0.664-0.664-1.741-0.664-2.406,0l-35.127,35.127c-0.665,0.665-0.665,1.742,0,2.406L176.615,60.809z M161.887,35.18l20.257-6.376 l6.377-20.257c0.27-0.859,1.186-1.339,2.046-1.066c0.858,0.27,1.336,1.187,1.065,2.046L185,30.595 c-0.16,0.508-0.558,0.906-1.066,1.066l-21.068,6.631c-0.162,0.051-0.327,0.076-0.489,0.076c-0.693,0-1.337-0.446-1.556-1.142 C160.55,36.367,161.028,35.451,161.887,35.18z"/> </g> </svg>')
            ->action(new Actions\SendSequence($this->resource), $this->resource->id)->hideWhenUpdating(),

            /*ActionButton::make('Honey') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet"><path d="M28.1 39.94l-3.92 4.04l24.37 22.83s55.65-12.72 55.65-13.2c0-.48.24-9.04.24-9.04s-.74-.98-1.23-1.5s-3.09-2.84-3.09-2.84l-72.02-.29z" fill="#ac5811"></path><path fill="#8a460a" d="M39.26 29.35l1.37 7.95l42.21 4.47l14.65-10.43l-25.82-4.72z"></path><path d="M32.66 43.22s-6.37-1.39-8.74-4.38c-1.4-1.77-1.48-4.33-.21-6.66c1.74-3.17 6.61-4.66 8.79-5.11c2.18-.45 13.6-4.36 33.67-3.76s39.99 5.04 39.61 12.1s-8.57 6.99-8.57 6.99l-1.2-12.1l-10.92.12s-11.93-1.31-20.04-1.62c-9.47-.35-16.32.52-16.32.52L35.5 31.65l-2.84 11.57z" fill="#e17f13"></path><path d="M69.64 38.1c.3-.3 22.55-23 22.55-23s-.32-3.35.08-5.04c.68-2.86 3.83-6.69 6.54-6.46c2.71.23 10.3 8.34 9.92 10.52s-2.63 4.74-4.89 5.56c-2.25.83-4.58.6-4.58.6l-18.8 18.8l-10.82-.98z" fill="#ae5614"></path><path d="M94.75 14.8c1.67.39 5.49-2.86 5.94-3.61c.45-.75-1.13-1.88-1.65-3.16s-.53-2.33-1.58-2.1c-1.05.23-2.85 2.2-3.31 3.83c-.68 2.41-.38 4.82.6 5.04z" fill="#df8116"></path><path d="M24.38 43.67s-8.02 8.39-7.54 20.54c.49 12.15 5.47 26.5 9.48 33.91s9.6 18.11 11.79 19.57c2.19 1.46 8.69 5.81 23.94 6.08c18.02.32 26.45-4.01 28.51-5.83c2.07-1.82 7.22-9.6 11.96-21.76s8.14-22.73 8.02-34.03s-6.13-17.56-6.13-17.56s-15.2 8.53-40.84 7.92s-39.19-8.84-39.19-8.84z" fill="#e07f14"></path><path d="M63.05 112.62c23.7.42 35.09-6.33 35.09-6.33s2.35-5.12 3.76-8.48c1.46-3.51 3.4-9.01 3.4-9.01s-9.21 8.26-42.29 8.4c-26.52.11-41.03-8.95-41.03-8.95s2.38 6.24 4.42 10.11c2.88 5.46 4.73 8.68 4.73 8.68s11.74 5.23 31.92 5.58z" fill="#ac5811"></path><path d="M50.48 28.49c.21-1.73-.73-7.63-12.56-6.94c-12.74.74-11.79 10.66-11.18 12.57c1.49 4.72 4.22 6.04 4.38 8.52c.17 2.48-1.9 8.27-2.32 18.37s.57 14.81.91 16.21c.64 2.62 2.56 4.3 4.63 2.98c2.07-1.32 1.08-5.21.83-7.53c-.25-2.32-.05-12.84.7-16.81c.74-3.97 1.65-6.52 4.05-5.85s1.63 4.05 1.46 6.86c-.17 2.81-.25 8.19.08 10.84s1.72 4.26 3.95 4.13c2.99-.17 3.66-2.56 3.82-6.53c.17-3.97-.08-6.7.58-10.59c.66-3.89 2.56-5.87 4.05-6.62c1.49-.74 4.88-1.32 10.01-1.16s9.18.5 10.75 2.73c1.57 2.23 2.07 7.61 4.96 9.76c2.9 2.15 6.2 0 7.28 2.32s1.74 7.78 1.82 14.15c.08 6.37-.66 14.64-1.16 18.2c-.5 3.56-1.72 8.6-.08 11.17c1.27 1.98 4.05 1.57 5.29-.91c1.24-2.48 1.99-7.94 2.56-14.23c.58-6.29.83-26.14 1.08-28.54c.25-2.4 2.02-7.81 4.55-15.72c2.75-8.61 5.88-15.55-.51-19.44c-3.41-2.08-5.54-1.77-5.54-1.77l-6.25 6.26s3.56.58 3.53 1.95c-.04 2.38-15.22 4.5-25.65 4.67s-24.94-1.86-24.94-4.51s8.5-1.15 8.92-4.54z" fill="#ffb803"></path><path d="M93.55 27.98c-.78 1.64.98 1.96 1.19 3.19c.2 1.23-.49 3.15.33 3.35s4.17-.94 3.43-4.5c-.74-3.56-4.44-3.13-4.95-2.04z" fill="#ffffff"></path><path d="M78.95 47.76c-1.03.25-.99 3.42.45 6.3c1.59 3.19 4.21 3.23 4.82 2.17s-1.06-2.17-2.17-4.13c-1.63-2.91-2.08-4.58-3.1-4.34z" fill="#ffffff"></path><path d="M39.83 37.21c-.8 1.33.9 3.47 5.44 4.78s6.91.41 7.03-1.27c.1-1.37-3.8-1.68-6.21-2.37c-2.42-.69-5.16-2.98-6.26-1.14z" fill="#ffffff"></path><path d="M36.23 23.39c-1.23-.68-5.52-.33-5.97 3.47c-.35 2.94 3.4 7.55 5.6 6.17c1.31-.82-.98-3.19-.33-5.15c.53-1.57 2.42-3.55.7-4.49z" fill="#ffffff"></path><path d="M43.34 64.55c-1.29.23-1.12 2.9-.83 3.87s.91 2.53 2.43 2.14c1.16-.3 1.01-2.21.76-3.33c-.26-1.13-.92-2.94-2.36-2.68z" fill="#fffcff"></path><path d="M31.39 74.17c-1.28.17-1.24 1.47-.86 3.07c.27 1.15 1.18 2.47 2.27 2.18c1.09-.29.87-1.78.55-2.87c-.29-.95-.62-2.56-1.96-2.38z" fill="#fffcff"></path><path d="M89.55 97.94c-1.36.07-1.26 1.8-1.31 3.51c-.05 1.71-.08 2.96 1.16 2.96c1.25 0 1.19-2.27 1.22-3.32s.38-3.22-1.07-3.15z" fill="#ffffff"></path></svg>')
            ->action(new Actions\HoneyPotStir, $this->resource->id)->hideWhenUpdating(),*/

            ActionButton::make('SMSer') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#cccdf0" stroke="#cccdf0"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <path d="M789.333333 832H234.666667l-128 128V234.666667c0-70.4 57.6-128 128-128h554.666666c70.4 0 128 57.6 128 128v469.333333c0 70.4-57.6 128-128 128z" fill="#ffffff"/> <path d="M512 469.333333m-64 0a64 64 0 1 0 128 0 64 64 0 1 0-128 0Z" fill="#2c8ed8"/> <path d="M725.333333 469.333333m-64 0a64 64 0 1 0 128 0 64 64 0 1 0-128 0Z" fill="#2c8ed8"/> <path d="M298.666667 469.333333m-64 0a64 64 0 1 0 128 0 64 64 0 1 0-128 0Z" fill="#2c8ed8"/> </g> </svg>')
            ->action(new Actions\SMSDominion($this->resource), $this->resource->id)->hideWhenUpdating(),

            ActionButton::make('Prop Event') // Name in resource table column
            ->icon('<svg fill="#000000" height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#000000"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <g> <g> <polygon points="410.861,364.199 410.861,324.053 379.514,324.053 379.514,364.199 341.372,364.199 341.372,395.546 379.514,395.546 379.514,435.692 410.861,435.692 410.861,395.546 449.004,395.546 449.004,364.199 "/> </g> </g> <g> <g> <path d="M493.388,317.388c-10.677-16.641-25.3-30.272-42.529-39.751V36.661H344.025v-23.6h-31.347v23.6H138.18v-23.6h-31.347v23.6 H0v394.255h287.229c5.955,12.704,14.185,24.384,24.189,34.213c22.191,21.803,51.541,33.81,82.643,33.81 C459.093,498.939,512,446.031,512,381C512,358.361,505.564,336.365,493.388,317.388z M31.347,68.008h75.487v30.735h31.347V68.008 h174.498v30.735h31.347V68.008h75.487v56.752H31.347V68.008z M284.848,336.527c-0.128,0.312-0.257,0.625-0.381,0.938H240.73 v-42.962h44.118V336.527z M240.729,263.156v-42.962h44.118v42.962H240.729z M58.27,188.848v179.965h218.489 c-0.419,4.029-0.637,8.097-0.637,12.188c0,4.193,0.229,8.455,0.679,12.666c0.114,1.067,0.246,2.132,0.39,3.196 c0.048,0.355,0.104,0.709,0.156,1.064c0.079,0.547,0.153,1.095,0.24,1.642H31.347V156.107h388.165v109.704 c-0.19-0.042-0.381-0.077-0.573-0.118c-0.544-0.117-1.089-0.228-1.635-0.336c-0.473-0.095-0.946-0.189-1.42-0.278 c-0.55-0.102-1.1-0.198-1.652-0.294c-0.473-0.082-0.948-0.165-1.422-0.24c-0.556-0.089-1.113-0.169-1.67-0.25 c-0.472-0.069-0.945-0.139-1.419-0.202c-0.566-0.075-1.135-0.141-1.703-0.208c-0.466-0.054-0.932-0.113-1.4-0.162 c-0.585-0.062-1.172-0.113-1.76-0.166c-0.452-0.041-0.905-0.087-1.358-0.122c-0.62-0.049-1.24-0.086-1.862-0.125 c-0.423-0.027-0.846-0.06-1.271-0.081c-0.692-0.037-1.387-0.06-2.08-0.084c-0.356-0.013-0.711-0.031-1.068-0.041 c-1.051-0.027-2.104-0.042-3.161-0.042c-0.743,0-1.484,0.013-2.225,0.026v-74.24H58.27z M165.265,263.156v-42.962h44.118v42.962 H165.265z M209.383,294.503v42.962h-44.118v-42.962H209.383z M89.617,263.156v-42.962h44.302v42.962H89.617z M133.918,294.503 v42.962H89.617v-42.962H133.918z M360.49,220.195v42.962h-44.296v-42.962H360.49z M394.061,467.592 c-22.833,0-44.381-8.816-60.673-24.824c-9.318-9.155-16.553-20.489-20.921-32.776c-2.273-6.393-3.785-13.007-4.496-19.66 c-0.332-3.109-0.502-6.249-0.502-9.333c0-24.92,10.756-48.651,29.531-65.126l0.568-0.497c7.129-6.144,15.151-11.055,23.84-14.597 c10.375-4.228,21.361-6.372,32.653-6.372c4.54,0,9.024,0.345,13.436,1.031c7.354,1.143,14.506,3.234,21.379,6.257l0.014,0.006 c0.891,0.392,1.778,0.793,2.653,1.213c29.833,14.352,49.11,45.002,49.11,78.085C480.653,428.747,441.808,467.592,394.061,467.592z "/> </g> </g> </g> </svg>')
            ->action(new Actions\ProperEvent, $this->resource->id)->hideWhenUpdating(),

            /*ActionButton::make('Vibe') // Name in resource table column
            ->icon($this->getSentimentIcon($this->resource->contact)) 
            ->action(new Actions\Sentementizer, $this->resource->id)->hideWhenUpdating()
            ->hideWhenUpdating(), */


            Multiselect::make('Journey')
        ->options([
          '1. Bait Tasted' => '1. Bait Tasted',
          '1.3. UEC' => '1.3. UEC',
          '2. Props Sent' => '2. Props Sent',
          '3. Appointment Set' => '3. Appointment Set',
          '4. Audit Sent' => '4. Audit Sent',
          '5. LP Hook' => '5. LP Hook',
          '5.5. Presentation Made' => '5.5. Presentation Made',
          '6. Pricing Sent' => '6. Pricing Sent',
          'A. Link Clicked' => 'A. Link Clicked',
          'E. Hot Lead' => 'E. Hot Lead',
          '7. Appointment Attended' => '7. Appointment Attended',
          'IOI. Price Request' => 'IOI. Price Request',
          'IOI. Timeline Request' => 'IOI. Timeline Request',
          'IOI. Opt in' => 'IOI. Opt in'
          

        ])
        ->placeholder('What is the customer journey') // Placeholder text
        ->max(4) // Maximum number of items the user can choose
        ->saveAsJSON() // Saves value as JSON if the database column is of JSON type
        ->optionsLimit(5)
        ->resolveUsing(function ($value) {
            return json_decode($value, true);
        })
        ->fillUsing(function ($request, $model, $attribute) {
            $model->$attribute = json_encode($request->{$attribute});
        }),// How many items to display at once
         // If you want a searchable single select field
                    
            

            
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            (new StackedChart())
    ->title('Effective Convos')
    ->model('\App\Models\Touchpoint') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->series(array([
        'label' => 'UECs',
        'filter' => [
            'key' => 'uec', // State Column for Count Calculation Here
            'value' => '1'
        ],
    ]))
    ->options([
        'showTotal' => false // Hide Show Total in Your Chart
    ])
    ->width('1/2'),

    (new StackedChart())
    ->title('Total Volume')
    ->model('\App\Models\Touchpoint') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->series(array([
        'label' => 'Voicemail',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Voicemail'
        ],
    ],[
        'label' => 'Not Interested',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Not Interested'
        ],
    ],[
        'label' => 'Call Me Back',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Call Me Back'
        ],
    ]))
    ->options([
        'btnFilter' => true,
        'btnFilterDefault' => '7',
        'btnFilterList' => [
            'YTD'   => 'Year to Date',
            'QTD'   => 'Quarter to Date',
            'MTD'   => 'Month to Date',
            '30'   => '30 Days', // numeric key will be set to days
            '7'   => '7 Days', // numeric key will be set to days
        ],
        'showTotal' => false, // Hide Show Total in Your Chart
        'latestData' => 6, // Show last 6 weeks data (optional)
        'uom' => 'day', // available in 'day', 'week', 'month', 'hour'
        'sweetAlert2' => [
            'linkTo' => 'https://coroo.github.io/nova-chartjs'
        ],
        'plugins' => [
            'datalabels' => true
        ]
    ])
    ->width('1/2'),

    (new StackedChart())
    ->title('Money Slam')
    ->model('\App\Models\Opps') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->options([
        'uom' => 'week',
        'latestData' => 12,
        'showTotal' => false, // Hide Show Total in Your Chart
        'sum' => 'price'
    ])
    ->width('1/2'),

    (new StackedChart())
    ->title('Money Slam')
    ->model('\App\Models\Campaign') // Use Your Model Here
    ->col_xaxis('created_at') // Add Your Custom X-Axis here
    ->series(array([
        'label' => 'Concept',
        'filter' => [
            'key' => 'status', // State Column for Count Calculation Here
            'value' => 'concept'
        ],
    ],[
        'label' => 'Ready',
        'filter' => [
            'key' => 'status', // State Column for Count Calculation Here
            'value' => 'ready'
        ],
    ],[
        'label' => 'Dispatched',
        'filter' => [
            'key' => 'status', // State Column for Count Calculation Here
            'value' => 'dispatched'
        ],
    ]))
    ->options([
        'uom' => 'month',
        'latestData' => 3,
        'showTotal' => false, // Hide Show Total in Your Chart
    ])
    ->width('1/2'),

    
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\TouchpointsToday,
            new Filters\AfterFilter,

        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new Actions\SeedMe,
            new Actions\SendEmailAction,
            new Actions\Clear,
            new Actions\Sentementizer,
            OppHit::make(),
            SMSDominion::make(),
            new Actions\CreateBDMLanding,
            SendSequence::make(),
            new Actions\HoneyPotStir,
            new Actions\SMSDominion,
            new Actions\SendSequence,
            new Actions\ProperEvent,
            new Actions\GoNuclear

        ];
    }

    private function getSentimentIcon($contact)
{

    dump("The contact passed is: ");
    dump($contact);
    // Replace with appropriate SVG icons for each sentiment
    $icons = [
        
        'brain-fucked' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M512,256c0,141.383-114.617,256-256,256S0,397.383,0,256S114.617,0,256,0S512,114.617,512,256"/> <g> <path style="fill:#FFFFFF;" d="M194.207,158.897c0,24.373-19.765,44.138-44.138,44.138c-24.373,0-44.138-19.765-44.138-44.138 s19.765-44.138,44.138-44.138C174.442,114.759,194.207,134.524,194.207,158.897"/> <path style="fill:#FFFFFF;" d="M406.069,158.897c0,24.373-19.765,44.138-44.138,44.138c-24.373,0-44.138-19.765-44.138-44.138 s19.765-44.138,44.138-44.138C386.304,114.759,406.069,134.524,406.069,158.897"/> </g> <path style="fill:#C03A2B;" d="M161.174,373.528c-24.691,6.091-45.171-18.538-34.957-41.816 c21.839-49.779,71.565-84.542,129.404-84.542c58.871,0,109.339,36.034,130.551,87.243c9.181,22.175-11.264,45.383-34.595,39.724 C308.515,363.685,238.901,354.345,161.174,373.528"/> <path style="fill:#4482C3;" d="M176.552,370.092v53.636c0,9.746,7.91,17.655,17.655,17.655s17.655-7.91,17.655-17.655v-17.655 c0,9.746,7.91,17.655,17.655,17.655c9.746,0,17.655-7.91,17.655-17.655v-43.564C225.015,362.871,201.287,365.087,176.552,370.092" /> <g> <path d="M158.897,176.552c0,4.873-3.955,8.828-8.828,8.828c-4.873,0-8.828-3.955-8.828-8.828c0-4.873,3.955-8.828,8.828-8.828 C154.942,167.724,158.897,171.679,158.897,176.552"/> <path d="M370.759,141.241c0,4.873-3.955,8.828-8.828,8.828c-4.873,0-8.828-3.955-8.828-8.828s3.955-8.828,8.828-8.828 C366.804,132.414,370.759,136.369,370.759,141.241"/> </g> </g> </svg>',
        'sick' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.011 512.011" xml:space="preserve"> <g transform="translate(-1)"> <path style="fill:#FBD971;" d="M504.472,256.005c0,136.67-110.797,247.467-247.467,247.467S9.539,392.675,9.539,256.005 S120.336,8.539,257.005,8.539S504.472,119.336,504.472,256.005"/> <g> <path style="fill:#E57E25;" d="M350.872,204.805c-23.526,0-42.667-19.14-42.667-42.667c0-4.719,3.814-8.533,8.533-8.533 c4.719,0,8.533,3.814,8.533,8.533c0,14.114,11.486,25.6,25.6,25.6s25.6-11.486,25.6-25.6c0-4.719,3.814-8.533,8.533-8.533 c4.719,0,8.533,3.814,8.533,8.533C393.539,185.665,374.399,204.805,350.872,204.805"/> <path style="fill:#E57E25;" d="M163.139,204.805c-23.526,0-42.667-19.14-42.667-42.667c0-4.719,3.814-8.533,8.533-8.533 c4.719,0,8.533,3.814,8.533,8.533c0,14.114,11.486,25.6,25.6,25.6c14.114,0,25.6-11.486,25.6-25.6 c0-4.719,3.814-8.533,8.533-8.533c4.719,0,8.533,3.814,8.533,8.533C205.805,185.665,186.665,204.805,163.139,204.805"/> </g> <g> <path style="fill:#24AE5F;" d="M367.939,418.139H146.072c-4.719,0-8.533-3.814-8.533-8.533V290.139 c0-4.719,3.814-8.533,8.533-8.533h221.867c4.719,0,8.533,3.814,8.533,8.533v119.467 C376.472,414.324,372.658,418.139,367.939,418.139"/> <path style="fill:#24AE5F;" d="M367.947,332.805c-3.132,0-6.144-1.724-7.646-4.719c-2.108-4.215-0.393-9.335,3.823-11.452 l136.533-68.267c4.207-2.091,9.335-0.393,11.452,3.823c2.108,4.215,0.393,9.335-3.823,11.452l-136.533,68.267 C370.533,332.515,369.227,332.805,367.947,332.805"/> <path style="fill:#24AE5F;" d="M444.205,426.38c-1.399,0-2.825-0.341-4.13-1.075l-76.28-42.377 c-4.122-2.287-5.606-7.484-3.311-11.597c2.278-4.122,7.475-5.623,11.597-3.319l76.271,42.377c4.13,2.295,5.615,7.484,3.319,11.597 C450.111,424.793,447.209,426.38,444.205,426.38"/> <path style="fill:#24AE5F;" d="M146.064,332.805c-1.28,0-2.586-0.29-3.806-0.896L5.724,263.643 c-4.215-2.116-5.931-7.236-3.823-11.452c2.116-4.215,7.236-5.914,11.452-3.823l136.533,68.267 c4.215,2.116,5.931,7.236,3.823,11.452C152.208,331.082,149.195,332.805,146.064,332.805"/> <path style="fill:#24AE5F;" d="M69.805,426.38c-3.004,0-5.905-1.587-7.467-4.395c-2.287-4.113-0.811-9.301,3.319-11.597 l76.271-42.377c4.113-2.304,9.318-0.802,11.605,3.319c2.287,4.113,0.802,9.31-3.319,11.597l-76.279,42.377 C72.63,426.039,71.205,426.38,69.805,426.38"/> </g> <g> <path style="fill:#FFFFFF;" d="M231.405,384.005c-2.185,0-4.369-0.836-6.033-2.5c-3.337-3.337-3.337-8.73,0-12.066l51.2-51.2 c3.337-3.337,8.73-3.337,12.066,0s3.337,8.73,0,12.066l-51.2,51.2C235.775,383.169,233.59,384.005,231.405,384.005"/> <path style="fill:#FFFFFF;" d="M282.605,384.005c-2.185,0-4.369-0.836-6.033-2.5l-51.2-51.2c-3.337-3.337-3.337-8.73,0-12.066 s8.73-3.337,12.066,0l51.2,51.2c3.337,3.337,3.337,8.73,0,12.066C286.975,383.169,284.79,384.005,282.605,384.005"/> </g> <g> <path style="fill:#E57E25;" d="M359.405,136.539c-23.526,0-42.667-19.14-42.667-42.667c0-4.719,3.814-8.533,8.533-8.533 c4.719,0,8.533,3.814,8.533,8.533c0,14.114,11.486,25.6,25.6,25.6c4.719,0,8.533,3.814,8.533,8.533 C367.939,132.724,364.124,136.539,359.405,136.539"/> <path style="fill:#E57E25;" d="M154.605,136.539c-4.719,0-8.533-3.814-8.533-8.533c0-4.719,3.814-8.533,8.533-8.533 c14.114,0,25.6-11.486,25.6-25.6c0-4.719,3.814-8.533,8.533-8.533c4.719,0,8.533,3.814,8.533,8.533 C197.272,117.399,178.132,136.539,154.605,136.539"/> </g> </g> </svg>',
        'another-world' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.002 512.002" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M503.322,260.34c0,138.986-112.675,251.661-251.661,251.661S0,399.326,0,260.34 S112.675,8.679,251.661,8.679S503.322,121.354,503.322,260.34"/> <g> <path style="fill:#F29C1F;" d="M355.797,190.916c-23.925,0-43.39-19.465-43.39-43.39c0-4.79,3.879-8.678,8.678-8.678 c4.799,0,8.678,3.888,8.678,8.678c0,14.353,11.681,26.034,26.034,26.034c14.353,0,26.034-11.681,26.034-26.034 c0-4.79,3.879-8.678,8.678-8.678c4.799,0,8.678,3.888,8.678,8.678C399.186,171.451,379.722,190.916,355.797,190.916"/> <path style="fill:#F29C1F;" d="M147.525,190.916c-23.925,0-43.39-19.465-43.39-43.39c0-4.79,3.879-8.678,8.678-8.678 c4.799,0,8.678,3.888,8.678,8.678c0,14.353,11.681,26.034,26.034,26.034c14.353,0,26.034-11.681,26.034-26.034 c0-4.79,3.879-8.678,8.678-8.678c4.799,0,8.678,3.888,8.678,8.678C190.915,171.451,171.451,190.916,147.525,190.916"/> </g> <path style="fill:#C03A2B;" d="M158.442,375.876c-24.272,5.988-44.405-18.215-34.365-41.108 c21.469-48.926,70.352-83.109,127.202-83.109c57.882,0,107.494,35.423,128.338,85.764c9.034,21.799-11.064,44.613-34,39.042 C303.286,366.2,234.852,357.018,158.442,375.876"/> <path style="fill:#4482C3;" d="M173.559,372.498v69.25c0,9.589,7.775,17.356,17.356,17.356s17.356-7.767,17.356-17.356v-17.356 c0,9.589,7.775,17.356,17.356,17.356s17.356-7.767,17.356-17.356v-59.349C221.201,365.4,197.875,367.578,173.559,372.498"/> <g> <path style="fill:#24AE5F;" d="M390.508,130.17h-34.712c-3.341,0-6.37-1.909-7.819-4.92c-1.441-3.003-1.041-6.578,1.041-9.181 L372.45,86.78h-16.653c-4.799,0-8.678-3.888-8.678-8.678s3.879-8.678,8.678-8.678h34.712c3.341,0,6.37,1.909,7.819,4.92 c1.441,3.003,1.041,6.578-1.041,9.181l-23.431,29.288h16.653c4.799,0,8.678,3.888,8.678,8.678S395.307,130.17,390.508,130.17"/> <path style="fill:#24AE5F;" d="M503.322,69.425h-52.068c-3.506,0-6.682-2.117-8.018-5.354c-1.345-3.246-0.599-6.977,1.883-9.459 l37.255-37.255h-31.119c-4.799,0-8.678-3.888-8.678-8.678s3.879-8.678,8.678-8.678h52.068c3.506,0,6.682,2.117,8.018,5.354 c1.345,3.246,0.599,6.977-1.883,9.459l-37.255,37.255h31.119c4.799,0,8.678,3.888,8.678,8.678S508.121,69.425,503.322,69.425"/> </g> </g> </svg>',
        'angry' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M512,256c0,141.383-114.617,256-256,256S0,397.383,0,256S114.617,0,256,0S512,114.617,512,256"/> <path style="fill:#C03A2B;" d="M324.634,370.764c-4.387,0-8.51-1.801-11.794-4.714c-15.316-13.559-34.613-21.778-56.841-21.778 c-22.219,0-41.525,8.218-56.841,21.778c-3.284,2.904-7.398,4.705-11.785,4.705h-0.459c-10.831,0-19.297-10.01-16.79-20.542 c9.26-38.85,44.2-67.734,85.875-67.734c41.684,0,76.615,28.893,85.875,67.734c2.507,10.531-5.959,20.551-16.781,20.551H324.634z"/> <path style="fill:#AF8066;" d="M353.103,203.034c-24.338,0-44.138-19.8-44.138-44.138s19.8-44.138,44.138-44.138 c24.338,0,44.138,19.8,44.138,44.138S377.441,203.034,353.103,203.034"/> <path style="fill:#F29C1F;" d="M300.138,170.789c-2.26,0-4.52-0.865-6.241-2.586c-3.452-3.452-3.452-9.031,0-12.482l62.994-62.985 c3.443-3.452,9.031-3.452,12.482,0c3.443,3.443,3.443,9.031,0,12.482l-62.994,62.985 C304.658,169.924,302.398,170.789,300.138,170.789"/> <path style="fill:#AF8066;" d="M158.897,203.034c-24.338,0-44.138-19.8-44.138-44.138s19.8-44.138,44.138-44.138 s44.138,19.8,44.138,44.138S183.234,203.034,158.897,203.034"/> <g> <path style="fill:#F29C1F;" d="M211.871,170.793c-2.26,0-4.52-0.865-6.241-2.586l-63.002-62.994 c-3.443-3.443-3.443-9.031,0-12.482c3.452-3.443,9.039-3.443,12.482,0l63.002,62.994c3.452,3.443,3.452,9.031,0,12.482 C216.391,169.928,214.131,170.793,211.871,170.793"/> <path style="fill:#F29C1F;" d="M316.707,419.017c-2.083,0-4.175-0.733-5.853-2.216c-14.451-12.8-32.079-19.562-50.979-19.562 s-36.529,6.762-50.988,19.562c-3.646,3.222-9.225,2.895-12.465-0.768c-3.231-3.646-2.887-9.225,0.759-12.465 c17.743-15.687,39.415-23.985,62.694-23.985s44.959,8.298,62.685,23.993c3.646,3.24,3.99,8.819,0.759,12.465 C321.571,418.011,319.144,419.017,316.707,419.017"/> </g> </g> </svg>',
        'ambivelent' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M512,256c0,141.383-114.617,256-256,256S0,397.383,0,256S114.617,0,256,0S512,114.617,512,256"/> <g> <path style="fill:#FFFFFF;" d="M194.207,167.724c0,24.373-19.765,44.138-44.138,44.138c-24.373,0-44.138-19.765-44.138-44.138 s19.765-44.138,44.138-44.138C174.442,123.586,194.207,143.351,194.207,167.724"/> <path style="fill:#FFFFFF;" d="M406.069,167.724c0,24.373-19.765,44.138-44.138,44.138c-24.373,0-44.138-19.765-44.138-44.138 s19.765-44.138,44.138-44.138C386.304,123.586,406.069,143.351,406.069,167.724"/> </g> <path style="fill:#E57E25;" d="M291.31,326.621H220.69c-4.882,0-8.828-3.955-8.828-8.828c0-4.873,3.946-8.828,8.828-8.828h70.621 c4.882,0,8.828,3.955,8.828,8.828C300.138,322.666,296.192,326.621,291.31,326.621"/> <g> <path d="M158.897,167.724c0,4.873-3.955,8.828-8.828,8.828c-4.873,0-8.828-3.955-8.828-8.828s3.955-8.828,8.828-8.828 C154.942,158.897,158.897,162.851,158.897,167.724"/> <path d="M370.759,167.724c0,4.873-3.955,8.828-8.828,8.828c-4.873,0-8.828-3.955-8.828-8.828s3.955-8.828,8.828-8.828 C366.804,158.897,370.759,162.851,370.759,167.724"/> </g> </g> </svg>',
        'starry' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M512,256c0,141.383-114.617,256-256,256S0,397.383,0,256S114.617,0,256,0S512,114.617,512,256"/> <path style="fill:#C03A2B;" d="M123.586,335.448c28.398,41.913,77.815,70.621,132.378,70.621 c54.607,0,104.051-28.654,132.449-70.621H123.586z"/> <g> <polygon style="fill:#E57E25;" points="158.897,114.759 178.273,151.349 220.69,158.897 190.252,188.213 203.034,229.517 158.897,203.034 114.759,229.517 127.541,188.213 97.103,158.897 139.52,151.349 		"/> <polygon style="fill:#E57E25;" points="353.103,114.759 372.48,151.349 414.897,158.897 384.459,188.213 397.241,229.517 353.103,203.034 308.966,229.517 321.748,188.213 291.31,158.897 333.727,151.349 		"/> </g> <path style="fill:#FB7B76;" d="M220.691,361.931c-18.07,0-33.986,9.084-43.529,22.899c23.384,13.391,50.379,21.239,78.804,21.239 c28.46,0,55.473-7.839,78.883-21.23c-9.551-13.824-25.459-22.908-43.538-22.908c-13.586,0-25.935,5.155-35.31,13.568 C246.626,367.086,234.276,361.931,220.691,361.931"/> </g> </svg>',
        'angel-vibes' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M490.306,277.698c0,129.406-104.899,234.305-234.305,234.305S21.696,407.103,21.696,277.698 S126.595,43.392,256.001,43.392S490.306,148.292,490.306,277.698"/> <g> <path style="fill:#E57E25;" d="M447.078,44.232h0.087H447.078z M65.508,43.39c8.426,9.771,76.08,26.034,190.49,26.034 c114.419,0,182.072-16.263,190.499-26.034c-8.426-9.771-76.08-26.034-190.499-26.034C141.588,17.356,73.934,33.618,65.508,43.39 L65.508,43.39z M255.998,86.78c-21.313,0-208.271-1.215-208.271-43.39S234.685,0,255.998,0c21.322,0,208.271,1.215,208.271,43.39 S277.32,86.78,255.998,86.78L255.998,86.78z"/> <path style="fill:#E57E25;" d="M177.9,208.274c-4.799,0-8.678-3.888-8.678-8.678c0-14.353-11.681-26.034-26.034-26.034 c-14.353,0-26.034,11.681-26.034,26.034c0,4.79-3.879,8.678-8.678,8.678c-4.799,0-8.678-3.888-8.678-8.678 c0-23.925,19.465-43.39,43.39-43.39s43.39,19.465,43.39,43.39C186.578,204.386,182.699,208.274,177.9,208.274"/> <path style="fill:#E57E25;" d="M386.171,208.274c-4.799,0-8.678-3.888-8.678-8.678c0-14.353-11.681-26.034-26.034-26.034 c-14.353,0-26.034,11.681-26.034,26.034c0,4.79-3.879,8.678-8.678,8.678c-4.799,0-8.678-3.888-8.678-8.678 c0-23.925,19.465-43.39,43.39-43.39s43.39,19.465,43.39,43.39C394.849,204.386,390.97,208.274,386.171,208.274"/> <path style="fill:#E57E25;" d="M247.29,407.867c-54.098,0-106.722-28.065-137.32-73.233c-2.69-3.966-1.657-9.364,2.317-12.054 c3.957-2.681,9.355-1.649,12.054,2.317c27.414,40.474,74.526,65.614,122.949,65.614c48.492,0,95.631-25.14,123.019-65.614 c2.681-3.966,8.062-4.999,12.045-2.317c3.966,2.681,5.016,8.079,2.326,12.054C354.115,379.802,301.466,407.867,247.29,407.867"/> </g> </g> </svg>',
        'onpoint' => '<svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <path style="fill:#FBD971;" d="M512,256c0,141.383-114.617,256-256,256S0,397.383,0,256S114.617,0,256,0S512,114.617,512,256"/> <g> <path style="fill:#E57E25;" d="M282.483,370.759h-97.103c-4.882,0-8.828-3.946-8.828-8.828c0-4.882,3.946-8.828,8.828-8.828 h97.103c19.474,0,35.31-15.837,35.31-35.31c0-4.882,3.946-8.828,8.828-8.828s8.828,3.946,8.828,8.828 C335.448,347.004,311.693,370.759,282.483,370.759"/> <path style="fill:#E57E25;" d="M393.25,145.353c-2.26,0-4.52-0.865-6.241-2.586c-8.43-8.43-20.427-12.023-32.124-9.622 c-4.82,0.962-9.446-2.092-10.425-6.859c-0.989-4.776,2.083-9.446,6.859-10.434c17.505-3.619,35.522,1.783,48.172,14.433 c3.452,3.452,3.452,9.031,0,12.482C397.77,144.488,395.51,145.353,393.25,145.353"/> <path style="fill:#E57E25;" d="M118.863,145.353c-2.26,0-4.52-0.865-6.241-2.586c-3.452-3.443-3.452-9.031,0-12.482 c12.606-12.615,30.561-18.026,48.031-14.46c4.776,0.971,7.865,5.632,6.894,10.408c-0.971,4.785-5.632,7.874-10.408,6.886 c-11.661-2.348-23.623,1.236-32.035,9.649C123.382,144.488,121.122,145.353,118.863,145.353"/> <path style="fill:#E57E25;" d="M185.379,203.034c-4.882,0-8.828-3.946-8.828-8.828c0-14.601-11.882-26.483-26.483-26.483 c-14.601,0-26.483,11.882-26.483,26.483c0,4.882-3.946,8.828-8.828,8.828c-4.882,0-8.828-3.946-8.828-8.828 c0-24.338,19.8-44.138,44.138-44.138s44.138,19.8,44.138,44.138C194.207,199.089,190.261,203.034,185.379,203.034"/> <path style="fill:#E57E25;" d="M397.241,203.034c-4.882,0-8.828-3.946-8.828-8.828c0-14.601-11.882-26.483-26.483-26.483 s-26.483,11.882-26.483,26.483c0,4.882-3.946,8.828-8.828,8.828s-8.828-3.946-8.828-8.828c0-24.338,19.8-44.138,44.138-44.138 s44.138,19.8,44.138,44.138C406.069,199.089,402.123,203.034,397.241,203.034"/> </g> <g> <path style="fill:#FB7B76;" d="M97.103,273.655c0,14.627-11.855,26.483-26.483,26.483s-26.483-11.855-26.483-26.483 s11.855-26.483,26.483-26.483S97.103,259.028,97.103,273.655"/> <path style="fill:#FB7B76;" d="M467.862,273.655c0,14.627-11.855,26.483-26.483,26.483c-14.627,0-26.483-11.855-26.483-26.483 s11.855-26.483,26.483-26.483C456.007,247.172,467.862,259.028,467.862,273.655"/> </g> </g> </svg>',
    ];

    if ($contact) {
        return $icons[$contact->sentiment] ?? $icons['ambivelent'];
    }

    
    return $icons['ambivelent'];
}
}