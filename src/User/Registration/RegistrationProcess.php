<?php

declare(strict_types=1);

namespace Teammates\User\Registration;

use Psr\Clock\ClockInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Teammates\User\User;
use Teammates\User\UserRepository;

final readonly class RegistrationProcess
{
    public function __construct(
        private UserRepository $userRepository,
        private UuidFactory $uuidFactory,
        private UserPasswordHasherInterface $userPasswordHasher,
        private ClockInterface $clock,
        private EmailVerifier $emailVerifier,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function createAccount(RegistrationDto $registerDto): User
    {
        $user = new User(
            $this->uuidFactory->create(),
            $registerDto->email,
            $registerDto->username,
            $this->clock->now()
        );

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $registerDto->plainPassword);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
        $this->emailVerifier->sendEmailConfirmation($user);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user->id()->toRfc4122()));

        return $user;
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function verifyUserEmail(string $uri, Uuid $userId, string $userEmail): void
    {
        $this->emailVerifier->handleEmailConfirmation($uri, $userId, $userEmail);

        $user = $this->userRepository->getById($userId);
        $user->verify($this->clock->now());

        $this->userRepository->save($user);

        $this->eventDispatcher->dispatch(new UserEmailVerifiedEvent($user->id()->toRfc4122(), $user->email(), $user->username()));
    }
}
