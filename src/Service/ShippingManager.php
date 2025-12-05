<?php

namespace App\Service;

use App\Repository\ProviderRepository;
use App\Service\Shipping\ShippingProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class ShippingManager
{
    private iterable $providers;

    // Inyectamos todos los servicios que implementen la interfaz (Tagged Iterator)
    public function __construct(
        #[TaggedIterator('app.shipping_provider')] iterable $providers,
        private ProviderRepository $providerRepository
    ) {
        $this->providers = $providers;
    }

    public function getQuotes(string $origin, string $destination): array
    {
        $results = [];
        $activeProviders = $this->providerRepository->findBy(['isActive' => true]);

        // Mapear providers de BD a sus servicios correspondientes
        foreach ($activeProviders as $provider) {
            foreach ($this->providers as $shippingProvider) {
                if ($shippingProvider->getProviderSlug() === $provider->getSlug()) {

                    // Ejecutar cotización 
                    $results[] = $shippingProvider->quote(
                        $origin,
                        $destination,
                        $provider->getApiUrl()
                    );
                }
            }
        }

        return $results;
    }
}