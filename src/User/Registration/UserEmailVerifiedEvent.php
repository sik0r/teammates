<?php

declare(strict_types=1);

namespace Teammates\User\Registration;

final readonly class UserEmailVerifiedEvent
{
    public function __construct(
        public string $userId,
        public string $email,
        public string $username
    ) {}
}
