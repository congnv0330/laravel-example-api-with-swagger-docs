<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Tag;
use App\Observers\BlogObserver;
use App\Observers\TagObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Tag::observe(TagObserver::class);
        Blog::observe(BlogObserver::class);
    }
}
