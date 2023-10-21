<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case PROCESSING = 1;
    case COMPLETED = 2;
    case CANCELED = 3;
}
