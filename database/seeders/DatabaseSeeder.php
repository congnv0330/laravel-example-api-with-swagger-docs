<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(5)->create();
        $tags = \App\Models\Tag::factory(15)->create();

        $status = StatusEnum::cases();

        \App\Models\Blog::factory(100)
            ->state(new Sequence(
                fn ($sequence) => [
                    'status' => $status[array_rand($status)]->value,
                    'creator_id' => $users->random()->id,
                    'updater_id' => $users->random()->id
                ]
            ))
            ->create()
            ->each(fn (\App\Models\Blog $blog) => $blog->tags()->saveMany($tags->random(rand(1, 5))));
    }
}
