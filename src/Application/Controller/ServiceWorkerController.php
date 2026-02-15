<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;

#[AsController]
final readonly class ServiceWorkerController
{
    public function __construct(
        private Environment $twig,
        private AssetMapperInterface $assetMapper,
        private CacheInterface $cache,
        #[Autowire('%env(SOURCE_COMMIT)%')]
        private string $sourceCommit,
    ) {
    }

    #[Route('/service-worker.js', name: 'service_worker', env: 'prod')]
    public function __invoke(): Response
    {
        $content = $this->cache->get(
            'service_worker_' . $this->sourceCommit,
            fn (ItemInterface $item): string => $this->renderServiceWorker()
        );

        return new Response($content, Response::HTTP_OK, [
            'Content-Type' => 'application/javascript',
        ]);
    }

    private function renderServiceWorker(): string
    {
        return $this->twig->render('service-worker.js.twig', [
            'cache_version' => $this->sourceCommit,
            'precache_assets' => $this->collectAssets(),
            'generated_at' => new \DateTimeImmutable(),
        ]);
    }

    /**
     * @return list<string>
     */
    private function collectAssets(): array
    {
        $assets = [
            '/',
            '/favicon.svg',
            '/favicon.ico',
            '/favicon-96x96.png',
            '/apple-touch-icon.png',
            '/manifest.json',
        ];

        foreach ($this->assetMapper->allAssets() as $asset) {
            $publicPath = $asset->publicPath;
            if (! str_starts_with($publicPath, '/')) {
                $publicPath = '/' . $publicPath;
            }

            $assets[] = $publicPath;
        }

        return array_values(array_unique($assets));
    }
}
