<?php

namespace Aaw0\AdnecPressReleases\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AdnecPressRelease extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'press_releases';

    public $appends = ['title','content','excerpt'];


    protected $casts = [
        'expire_date' => 'datetime',
        'publish_date' => 'datetime',
    ];


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeHasLocalizedTitle($query,$locale)
    {
        return $query->where('title_'.$locale, '!=',null);//=>tryng to make it work
    }

    public function isPublished()
    {
        return $this->is_published;
    }

    public function isDraft()
    {
        return !$this->is_published;
    }

    public function getTitleAttribute()
    {
        $title = 'title_' . App::getLocale();
        return $this->$title ?? $this->title_en;
    }




    public function getExcerptAttribute()
    {
        $excerpt = 'excerpt_' . App::getLocale();
        return $this->$excerpt ?? $this->excerpt_en;
    }
    public function getContentAttribute()
    {
        $content = 'content_' . App::getLocale();
        return $this->$content ?? $this->content_en;
    }


    public function getPublicationDateAttribute()
    {
        if(!$this->publish_date) {
            return;
        }
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $this->publish_date)->year;
        $month = Carbon::createFromFormat('Y-m-d H:i:s', $this->publish_date)->shortMonthName;
        $day = Carbon::createFromFormat('Y-m-d H:i:s', $this->publish_date)->day;
        return $day.' '.$month.' '.$year;
    }

    public function registerMediaConversions(Media $media = null) : void
    {

        $this->addMediaConversion('medium')
            ->width(400)
            ->height(400)
            ->sharpen(10);
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('image')->singleFile();//=> for thumbnail
        $this->addMediaCollection('wide_image')->singleFile();//=> for wide image used on top of the press release
        $this->addMediaCollection('photos');//=> to be used as a gallery or collection or album
    }

    public function getImageAttribute()
    {
        return $this->getFirstMedia('image') ? $this->getFirstMedia('image')->getFullUrl() : '';
    }
    public function getWideImageAttribute()
    {
        return $this->getFirstMedia('wide_image') ? $this->getFirstMedia('wide_image')->getFullUrl() : '';
    }
    public function getImageMediumAttribute()
    {
        return $this->getFirstMedia('image') ? $this->getFirstMedia('image')->getFullUrl('medium') : '';
    }
    public function getThumbnailAttribute()
    {
        return $this->getFirstMedia('image') ? $this->getFirstMedia('image')->getFullUrl('thumb') : '';
    }
}
