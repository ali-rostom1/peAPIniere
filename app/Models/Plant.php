<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Plant extends Model
{
    use HasFactory,HasSlug;
    protected $fillable = [
        'name',
        'price',
        'category',
        'description',
        'admin_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
