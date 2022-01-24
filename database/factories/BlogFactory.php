<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text('100'),
            'description' => $this->faker->text('150'),
            'content' => $this->faker->realTextBetween(300, 1000),
            'thumbnail_image' => '',
            'cover_image' => ''
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Blog $blog) {
            $blog->slug()->create([
                'value' => generate_slug($blog->title)
            ]);
        });
    }
}
