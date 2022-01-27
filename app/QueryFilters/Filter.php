<?php

namespace App\QueryFilters;

use Illuminate\Http\Request;

abstract class Filter
{
    public Request $request;

    public function __construct()
    {
        $this->request = app('request');
    }
}
