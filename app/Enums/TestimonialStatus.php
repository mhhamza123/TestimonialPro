<?php

namespace App\Enums;

enum TestimonialStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;

    public function label()
    {
        return match($this){
            static::ACTIVE => __('Active'),
            static::INACTIVE => __('in Active'),
        };
    }
}
