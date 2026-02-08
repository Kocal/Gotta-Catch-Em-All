<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Data\Model\User;
use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Repository\UserPokemonRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final readonly class TogglePokemonCaughtController
{
    public function __construct(
        private UserPokemonRepository $userPokemonRepository,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/toggle_pokemon_caught', name: 'app_toggle_pokemon_caught')]
    #[IsGranted('ROLE_USER')]
    public function __invoke(
        #[MapQueryParameter]
        int $pokemonId,
        #[CurrentUser]
        User $user,
    ): \Symfony\Component\HttpFoundation\RedirectResponse {
        $pokemonId = PokemonId::fromInt($pokemonId);

        $this->userPokemonRepository->toggleCaught($user->id, $pokemonId);

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}
