<?php

namespace App\Enums;

enum TicketStatusEnum: int
{
    case ACTIVE = 1;
    case LOCKED = 2;
}
