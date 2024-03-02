<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController
{
    #[Route('/', name: 'hello')]
    public function hello(): JsonResponse
    {
        return new JsonResponse(['hello' => 'world']);
    }
}
