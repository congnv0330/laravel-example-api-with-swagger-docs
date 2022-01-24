<?php

use Illuminate\Support\Str;

if (!function_exists('generate_slug')) {
    /**
     * Generate unique slug from string input
     *
     * @param string $input
     * @return string
     */
    function generate_slug(string $input): string
    {
        return Str::slug($input . ' ' . Str::random(10));
    }
}
