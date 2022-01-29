<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogObserver
{
    /**
     * Handle the Blog "creating" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function creating(Blog $blog)
    {
        $blog->creator()->associate(Auth::guard('api')->user());
        $blog->updater()->associate(Auth::guard('api')->user());
    }

    /**
     * Handle the Blog "updating" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function updating(Blog $blog)
    {
        $blog->updater()->associate(Auth::guard('api')->user());
    }

    /**
     * Handle the Blog "deleted" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function deleted(Blog $blog)
    {
        $blog->slug()->delete();
        $blog->tags()->detach();
    }

    /**
     * Handle the Blog "restored" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function restored(Blog $blog)
    {
        //
    }

    /**
     * Handle the Blog "force deleted" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function forceDeleted(Blog $blog)
    {
        //
    }
}
