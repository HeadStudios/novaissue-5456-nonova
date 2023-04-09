<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Formfeed\DependablePanel\DependablePanel;
use Laravel\Nova\Fields\Boolean;
use App\Nova\Filters\ByCourseFilter;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Facades\Env;
use Whitecube\NovaFlexibleContent\Flexible;
use Waynestate\Nova\TextCopy\TextCopy;



class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

    

    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->id != 1) {
            return $query->where('id', $request->user()->id);
        }
    }
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

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
            ID::make()->hideFromIndex()->sortable(),
            Select::make('Role')
            ->options([
                'admin' => 'Admin',
                'student' => 'Student',
            ])
            ->displayUsingLabels(),
            //BelongsTo::make('Contacts', 'contacts', 'App\Nova\Contact')->searchable(),
            
            //Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
                
                
                



            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

                BelongsTo::make('Contact', 'contacts', 'App\Nova\Contact')->hideFromIndex()->searchable()->nullable(), 

                TextCopy::make('Screenshot', 'screenshot'),
                TextCopy::make('Full URL', 'full_url'),

                Image::make('Company Logo')->disk('s3')->hideFromIndex(),
                Image::make('Profile Image')->disk('s3')->hideFromIndex(),
                    Image::make('Hero Image')->disk('s3')->hideFromIndex(),
                
                Image::make('Favicon URL')->disk('s3')->hideFromIndex(),


                DependablePanel::make('Landing Page Fields', [

                    
                    Text::make('Mobile'),
                    Text::make('Company Permalink')->hideFromIndex(),
                    Text::make('Company Name'),
                    Text::make('Website URL'),
                    Textarea::make('Address'),
                    Text::make('Area')->hideFromIndex(),

    
    
                ])->separatePanel(true),

            //BelongsToMany::make('Courses', 'courses', Course::class)->display('name'),
            BelongsToMany::make('Roles', 'roles', Role::class)->display(function ($role) { return $role->name; }),
            BelongsToMany::make('Courses', 'courses', Course::class),
            BelongsToMany::make('Checklists')->fields(function ($request, $relatedModel) {
                return [
                    Boolean::make('Status'),
                    Boolean::make('Approved'),
                ];
            })->display('name'),
            /*BelongsToMany::make('Vlesson')->display('title')->fields(function ($request, $relatedModel) {
               
                return [
                    Text::make('Computed', function () use($relatedModel) {
                        
                        return "<a href='/vlesson/".$relatedModel->permalink."?".$this->magic."'>Boomba</a>";
                    })->asHtml()
                ];
            }),*/
            BelongsToMany::make('Lessons Assigned', 'vlessons', Vlesson::class)
            ->fields(function ($request, $relatedModel) {
                
                $id = $request->viaResourceId;
                
                //
                return [
                    
        
                    Text::make('Magic Link', function ($pivot) use($id, $relatedModel) {
                        
                        
                        
                        $user = User::find($id);
                        if(isset($relatedModel->permalink)) { 
                            return env('APP_URL')."/lms/ovlesson/".$relatedModel->permalink."?magic=".$user->magic; 
                        } else { return "Magic"; }
                   
                    })->copyable(),
                    Boolean::make('Watched', function($pivot) {
                        if($pivot->watched == 1) {
                            return true;
                        } else {
                            return false;
                        }
                    }),
                ];
            }),

            Flexible::make('Access Codes')
                ->addLayout('Access Code', 'code', [
                    Text::make('Login URL'),
                    Text::make('Username'),
                    Text::make('Password')
                ]), 
                HasMany::make('Campaigns')

            
            /*
            Text::make('Magic Link', function () {
                        return $this->first_name.' '.$this->last_name;
                    })->asHtml()
            */
            

            
        ];
    }

    public function computed()
  {
    //
    return "HELLOOOO!!!";
  }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
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

            new Actions\Userea,
            new Actions\SendADrippy,
            new Actions\SeedAnOnboard,
            new Actions\AttachCourseToUser,
            new Actions\SendCourseToUser,
            new Actions\SendCourseToUser,
            new Actions\TakeScreenshot
        ];
    }
}
