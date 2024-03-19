<?php

declare(strict_types=1);

namespace Teammates\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;
use Teammates\User\Registration\UserEmailVerifiedEvent;

final readonly class UserActivatedAccountSubscriber implements EventSubscriberInterface
{
    public function __construct(private UuidFactory $uuidFactory, private ParticipantRepository $participantRepository) {}

    #[\Override]
    public static function getSubscribedEvents(): iterable
    {
        return [
            UserEmailVerifiedEvent::class => 'onUserActivatedAccount',
        ];
    }

    public function onUserActivatedAccount(UserEmailVerifiedEvent $event): void
    {
        $participant = new Participant(
            $this->uuidFactory->create(),
            Uuid::fromString($event->userId),
            $event->username,
        );

        $this->participantRepository->save($participant);
    }
}
