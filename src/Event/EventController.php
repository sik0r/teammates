<?php

declare(strict_types=1);

namespace Teammates\Event;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/events', name: 'events_index')]
    public function events(): Response
    {
        return $this->render('event/index.html.twig');
    }
}
