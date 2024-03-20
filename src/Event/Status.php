<?php

declare(strict_types=1);

namespace Teammates\Event;

enum Status
{
    case DRAFT;
    case ACTIVE;
    case FINISHED;
    case CANCELLED;
}
