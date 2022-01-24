<?php

namespace App\Enums;

enum StatusEnum: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;
    case ARCHIVED = 2;

    public function name(): string
    {
        return match($this)
        {
            StatusEnum::DRAFT => 'Draft',
            StatusEnum::PUBLISHED => 'Published',
            StatusEnum::ARCHIVED => 'Archived'
        };
    }
}
