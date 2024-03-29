<?php

declare(strict_types=1);

namespace Teammates\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'hello')]
    public function hello(): Response
    {
        return $this->render('base.html.twig');
    }
}
