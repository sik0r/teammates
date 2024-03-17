<?php

declare(strict_types=1);

namespace Teammates\User\Registration;

class RegistrationDto
{
    public ?string $email = null;
    public ?string $username = null;
    public ?string $plainPassword = null;
    public ?bool $agreeTerms = null;
}
