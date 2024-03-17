<?php

declare(strict_types=1);

namespace Teammates\User\Registration;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Uid\Uuid;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Teammates\User\User;

final readonly class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer
    ) {}

    public function sendEmailConfirmation(User $user): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'app_verify_email',
            $user->id()->toRfc4122(),
            $user->email(),
            ['id' => $user->id()->toRfc4122(), 'email' => $user->email()]
        );

        $email = $this->createEmail($user, $signatureComponents);
        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(string $uri, Uuid $userId, string $userEmail): true
    {
        $this->verifyEmailHelper->validateEmailConfirmation(
            $uri,
            $userId->toRfc4122(),
            $userEmail
        );

        return true;
    }

    private function createEmail(
        User $user,
        VerifyEmailSignatureComponents $signatureComponents
    ): TemplatedEmail {
        return (new TemplatedEmail())
            ->from(new Address('no-reply@teammates.pl', 'Teammates'))
            ->to($user->email())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('user/registration/confirmation_email.html.twig')
            ->context(
                [
                    'signedUrl' => $signatureComponents->getSignedUrl(),
                    'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(
                    ),
                    'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(
                    ),
                ]
            )
        ;
    }
}
