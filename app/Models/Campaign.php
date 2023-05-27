<?php

namespace App\Nova;
use Laravel\Nova\Fields\Select;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Kostasmatrix\Autofiller\Autofiller;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Auth;
use App\Nova\User as UserResource;
use App\Models\User;
use Laravel\Nova\Fields\BooleanGroup;
use Formfeed\DependablePanel\DependablePanel;
use App\Nova\Metrics\Clicks;
use Laravel\Nova\Fields\Number;
use Waynestate\Nova\TextCopy\TextCopy;
use Oneduo\NovaFileManager\FileManager;
use Laravel\Nova\Panel;



use App\Nova\Lenses\campaign_list;


class Campaign extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Campaign::class;

    public static $searchable = true;


    /**
     * The columns that should be searched.
     *
     * @var array
     */


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $group = 'Expert Position';
    public static $title = 'headline';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'headline',
    ];

    


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $user = User::where('id', $this->author?->id)->first();

        return [
            //ID::make()->sortable(),
            BelongsTo::make('Author', 'author', UserResource::class)->nullable()->searchable(),
            ID::make('id'),
            BelongsTo::make('Gift Type', 'giftType', GiftType::class)
                ->displayUsing(function ($giftType) {
                    return $giftType->permalink;
                })->nullable(),
            TextCopy::make('Screenshot', 'screenshot')->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            
            BelongsTo::make('Offer')->nullable(),
            TextCopy::make('Link', function() {
                if (!isset($this->author->company_permalink)) {
                    return '';
                }
                return env('APP_URL').'/vblog/'.$this->author->company_permalink.'/'.$this->category.'/'.$this->permalink;
            })->copyValue(function ($value) {
                $user = User::where('id', $this->author?->id)->first();
                if (!isset($this->author->company_permalink)) {
                    return '';
                }
                return env('APP_URL').'/vblog/'.$this->author?->company_permalink.'/'.$this->category.'/'.$this->permalink;
            }),
            Select::make('Template', 'template_view')->options([
                'campaign-single' => 'campaign-single',
                'campaign-single-fresh' => 'campaign-single-fresh',
                'single.tursa-single' => 'single.tursa-single',
                'single.vsl-pm' => 'single.vsl-pm (Property Management Landing)',
                'single.vsl-rrds' => 'single.vsl-rrds (Rent Roll Devour Landing)',
            ])->displayUsingLabels()->hideFromIndex()->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            
            Select::make('Category', 'category')->options([
                'property-management' => 'Property Management - property-management',
                'rrds' => 'Rent Roll Devour System - rrds',
                'discord' => 'Discord Peeps - discord',
                'tursa' => 'Tursa Peeps - tursa'
            ])->displayUsingLabels()->hideFromIndex()->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            Text::make('Permalink', 'permalink'),
            Image::make('MMS Image', 'mms_image')->disk('s3')->hideFromIndex()->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            Image::make('Video Thumbnail', 'video_thumbnail')->disk('s3')->hideFromIndex()->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            
            Image::make('Partner', 'partner')->disk('s3')->hideFromIndex(),
            FileManager::make(__('Nova File'), 'nova_file')->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
            BooleanGroup::make('Landing Page Sections', 'display')->options(function () {
                $options = [        'landing' => 'Landing Page Fields',   'misc' => 'Video Fields',     'email' => 'Email Campaign Fields',        'mms' => 'MMS Campaign'   ];
                
                // Only display the first two options if the user is not an admin
                if (!auth()->user()->hasRole('admin')) {
                    $options = array_slice($options, 0, 2, true);
                }
            
                return $options;
            })->onlyOnForms()->fillUsing(fn () => null),

            
            
            
            Text::make('Shortlink', function () {
                return '<a target="_blank" class="link-default" href="'.env('APP_URL').'/offer/'.$this->shortlink_path.'">'.env('APP_URL').'/offer/'.$this->shortlink_path.'</a>'; 
                })->asHtml()->hideFromIndex()->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),

                Trix::make('Notes')->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),

                Flexible::make('Video Props')
            ->addLayout('Video Prop', 'prop_single', [
                Text::make('Title'),
                Text::make('Name'),
                TextArea::make('Property')
            ]),

                
                

            new Panel('Landing Page Fields', $this->landingFields()),
            /*DependablePanel::make('Landing Page Fields', [
                
                
                
                
                ])->separatePanel(true)->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),*/

               
            
            DependablePanel::make('Email Fields', [
            Heading::make('Please add {{first_name}} into the subject and email field for first name and {{link}} for the link')->asHtml(),
            Text::make('Email Subject'),
            Markdown::make('Email Body', 'email_body')->hideFromIndex(),
            ])->separatePanel(true)->dependsOn(['display'], function ($field, $request, $formData) {
                $this->showWhenDisplayIs('email', $field, $formData);
            })->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),

            DependablePanel::make('MMS', [

                Text::make('Shortlink Path', 'shortlink_path'),
                
            
                Textarea::make('MMS Message', 'mms_msg'),
                ])->separatePanel(true)->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('mms', $field, $formData);
                })->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),


            DependablePanel::make('Video Fields', [
               
                  

                

            
                
                ])->separatePanel(true)->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('misc', $field, $formData);
                }),

                Textarea::make('Video Script', 'video_script')->hideFromIndex()->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),
            Text::make('Movio Video ID')->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),

                Text::make('CTA Text', 'cta_text')->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),
                Text::make('CTA Link', 'cta_link')->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),
                // GO!
                /*

                TextCopy::make('Video Thumbnail' 'video_thumbnail'),, function() { return env('APP_URL').'/vblog/'.$this->author->company_permalink.'/'.$this->category.'/'.$this->permalink; })->copyValue(function ($value) {
                $user = User::where('id', $this->author?->id)->first();
                return env('APP_URL').'/vblog/'.$this->author?->company_permalink.'/'.$this->category.'/'.$this->permalink;
                })->hideFromindex(),

                */
                //TextCopy::make('Video Thumbnail', 'video_thumbnail'),
                
                Textarea::make('Excerpt', 'excerpt')->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                }),
            
            
            //BelongsTo::make('Author', 'author', 'App\Nova\User')->searchable()->hideWhenCreating()->hideWhenUpdating(),

            //Autofiller::make('Templater', 'template_null')->hideFromIndex()->max(69)->hideFromDetail()->hideWhenUpdating()->hideFromIndex(),
            
            
            
            
            
            
            
            
            
            
            

            Boolean::make('Campaign Ready', 'campaign_ready')->withMeta(['extraAttributes' => [
                'readonly' => true
          ]])->hideWhenUpdating()->canSee(function ($request) {
            return $request->user()->hasRole('admin');
        }),


        Select::make('Status')
    ->options([
        'concept' => 'Concept',
        'ready' => 'Ready',
        'dispatched' => 'Dispatched',
    ])
    ->displayUsingLabels(),

    
          
          
          
            HasMany::make('Campaign_Contacts')
        ];
    }

    protected function landingFields() {

        return [
            Text::make('Headline', 'headline')->dependsOn(['display'], function ($field, $request, $formData) {
                $this->showWhenDisplayIs('landing', $field, $formData);
            }),
                Text::make('Subheadline', 'subheadline')->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),
                
                Text::make('Tik Tok URL', 'tiktok_url')->hideFromIndex()->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),
                Heading::make('Add the merge <b>{!offer}</b> to add offer to be modified later')->asHtml()->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),

                Markdown::make('Copy', 'copy')->hideFromIndex()->withFiles('s3')->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),
                
                Boolean::make('Template')->sortable()->canSee(function ($request) {
                    return $request->user()->hasRole('admin');
                })->dependsOn(['display'], function ($field, $request, $formData) {
                    $this->showWhenDisplayIs('landing', $field, $formData);
                }),

                Flexible::make('FFMPEG')
    ->addLayout('Inputs', 'prop_single', [
        Text::make('File'),
        Text::make('Name'),
        Text::make('Entry'),
        Flexible::make('Overlays')
        ->addLayout('Headlines', 'headlines', [
            Text::make('Number'),
            Text::make('Headline'),
            Text::make('Subheadline'),
        ])->addLayout('Image Overlays', 'image_overlays', [
            Text::make('Image Name'),
            Number::make('Start'),
            Number::make('End'),
        ]),
    ])->canSee(function ($request) {
        return $request->user()->hasRole('admin');
    })->dependsOn(['display'], function ($field, $request, $formData) {
        $this->showWhenDisplayIs('landing', $field, $formData);
    }),
            ];

    }

        /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    
    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->id != 1) {
        return $query->where('author_id', $request->user()->id);
        }
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
            (new Metrics\Clicks)->onlyOnDetail(),
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
            new Filters\CampaignFilter
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
        return [
            new campaign_list()
        ];
    }

    protected static function fillFields(NovaRequest $request, $model, $fields)
    {
        $fillFields = parent::fillFields($request, $model, $fields);

        // first element should be model object
        $modelObject = $fillFields[0];

        // remove all attributes do not have relevant columns in model table

        return $fillFields;
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
            new Actions\ShortBurst,
            new Actions\AttachContacts,
            new Actions\SendMMS,
            new Actions\Userea,
            new Actions\SendPortalSync,
            new Actions\TestAction,
            new Actions\TakeScreenshot,
            new Actions\PropItUp
        ];
    }

    protected function showWhenDisplayIs($key, $field, $formData) {
        if($formData->display) {
            $display = json_decode($formData->display);
            
            if(isset($display->{$key}) && ($display->{$key} === true)) {
                $field->show();
            } else {
                $field->hide();
            }
        } else {
            $field->hide();
        }
    }
}
