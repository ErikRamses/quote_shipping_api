<?php

namespace App\Service\Shipping\Provider;

use App\Service\Shipping\ShippingProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class FastTrackProvider implements ShippingProviderInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger
    ) {
    }

    public function getProviderSlug(): string
    {
        return 'fast_track';
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
                    'provider' => 'Fast Track Logistics',
                    'price' => 150.00,
                    'currency' => 'MXN',
                    'delivery_days' => 2,
                    'status' => 'success'
                ];
            }

            throw new \Exception('Service unavailable');

        } catch (\Throwable $e) {
            $this->logger->error('Error in FastTrack: ' . $e->getMessage());
            return [
                'provider' => 'Fast Track Logistics',
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}