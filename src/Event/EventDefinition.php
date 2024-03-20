<?php

declare(strict_types=1);

namespace Teammates\Event;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'event_definition')]
class EventDefinition
{
    private Uuid $id;
    private Participant $organizer;
    private Collection $participants;
    private int $maxParticipants;
    private string $name;
    private Status $status;
    private string $activityType; //football, basketball, etc
    private array $tags;
    private ?string $description;
    private string $location; //country, city, address
    private \DateTimeImmutable $date;
    private \DateTimeImmutable $createdAt;
}
