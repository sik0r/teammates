<?php

declare(strict_types=1);

namespace Teammates\User\Registration;

final readonly class UserRegisteredEvent
{
    public function __construct(public string $userId) {}
}
