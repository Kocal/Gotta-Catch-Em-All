<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class HomeController
{
    public function __construct(
        private \Twig\Environment $twig,
    )
    {
    }

    #[Route('/', name: 'home')]
    public function __invoke(): Response
    {
        return new Response($this->twig->render('home/index.html.twig'));
    }
}
