<?php

namespace Aaw0\AdnecPressReleases;

use Laravel\Nova\Resource;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;

class AdnecPressRelease extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Aaw0\AdnecPressReleases\Models\AdnecPressRelease::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title_ar','title_en'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Images::make('Image', 'image')
            ->conversionOnPreview('medium')
            ->conversionOnDetailView('thumb')
            ->conversionOnIndexView('thumb')->enableExistingMedia(),
            Images::make('Main Image', 'main_image')->hideFromIndex()
            ->conversionOnPreview('medium')
            ->conversionOnDetailView('thumb')
            ->conversionOnIndexView('thumb')->enableExistingMedia(),
            Boolean::make('Is Published')->sortable()->required(),
            Text::make('Title Ar')->sortable()->rules('required', 'max:255')->hideFromIndex(),
            Slug::make('Slug Ar')->from('title_ar')->sortable()
            ->rules('required', 'max:255')
            ->creationRules('unique:press_releases,slug_ar')
            ->updateRules('unique:press_releases,slug_ar,{{resourceId}}')->hideFromIndex(),
            Text::make('Title En')->sortable()->rules('required', 'max:255'),
            Slug::make('Slug En')->from('title_en')->sortable()
            ->rules('required', 'max:255')
            ->creationRules('unique:press_releases,slug_en')
            ->updateRules('unique:press_releases,slug_en,{{resourceId}}')->hideFromIndex(),

            Text::make('Excerpt Ar')->rules('nullable', 'max:1000')->hideFromIndex(),
            Text::make('Excerpt En')->rules('nullable', 'max:1000')->hideFromIndex(),
            DateTime::make('Publish Date')->hideFromIndex()->nullable(),
            DateTime::make('Expire Date')->hideFromIndex()->nullable(),
            Text::make('Publish Date')->sortable()->displayUsing(function ($value) {
                return $value ? Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('Y-m-d') : null;
            })->onlyOnIndex(),
            Text::make('Expire Date')->sortable()->displayUsing(function ($value) {
                return $value ? Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('Y-m-d') : null;
            })->onlyOnIndex(),

            Trix::make('Content Ar')->nullable(),
            Trix::make('Content En')->nullable(),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
