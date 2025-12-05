<?php

namespace App\Service\Shipping\Provider;

use App\Service\Shipping\ShippingProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class HikerCargoProvider implements ShippingProviderInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger
    ) {
    }

    public function getProviderSlug(): string
    {
        return 'hiker_cargo';
    }

    public function quote(string $originZip, string $destZip, string $url): array
    {
        try {
            // Simulamos llamada a webhook.site
            $response = $this->client->request('GET', $url, [
                'query' => ['from' => $originZip, 'to' => $destZip]
            ]);

            // Forzamos éxito simulado si el webhook responde 200
            if ($response->getStatusCode() === 200) {
                return [
                    'provider' => 'Hiker Cargo',
                    'price' => 150.00,
                    'currency' => 'MXN',
                    'delivery_days' => 2,
                    'status' => 'success'
                ];
            }

            throw new \Exception('Service unavailable');

        } catch (\Throwable $e) {
            $this->logger->error('Error in Hiker Cargo: ' . $e->getMessage());
            return [
                'provider' => 'Hiker Cargo',
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}