<?php

declare(strict_types=1);

namespace Teammates\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'participant')]
class Participant
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $id;

    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $userId;

    #[ORM\Column(length: 50, unique: true)]
    private string $name;

    public function __construct(Uuid $id, Uuid $userId, string $name)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function name(): string
    {
        return $this->name;
    }
}
