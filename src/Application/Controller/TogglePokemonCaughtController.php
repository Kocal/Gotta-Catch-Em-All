<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Data\Model\User;
use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Repository\UserPokemonRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final readonly class TogglePokemonCaughtController
{
    public function __construct(
        private UserPokemonRepository $userPokemonRepository,
    ) {
    }

    #[Route('/pokemon/{pokemonId}/toggle', name: 'app_toggle_pokemon_caught', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(
        int $pokemonId,
        #[CurrentUser]
        User $user,
    ): JsonResponse {
        $pokemonId = PokemonId::fromInt($pokemonId);

        $isCaught = $this->userPokemonRepository->toggleCaught($user->id, $pokemonId);

        return new JsonResponse([
            'caught' => $isCaught,
        ]);
    }
}
