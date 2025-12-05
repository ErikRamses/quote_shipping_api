<?php

namespace App\Controller;

use App\Service\ShippingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/api', name: 'api_')]
class QuoteController extends AbstractController
{
    #[Route('/quote', name: 'quote', methods: ['POST'])]
    public function index(Request $request, ShippingManager $shippingManager, LoggerInterface $logger): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validación simple
        if (!isset($data['originZipcode']) || !isset($data['destinationZipcode'])) {
            $logger->error('Intento de cotización con datos incompletos.');
            return $this->json(['error' => 'Missing zipcodes'], 400);
        }

        $origin = $data['originZipcode'];
        $dest = $data['destinationZipcode'];

        $logger->info("Iniciando cotización de $origin a $dest");

        // Llama al manager que orquesta los servicios externos
        $quotes = $shippingManager->getQuotes($origin, $dest);

        return $this->json([
            'origin' => $origin,
            'destination' => $dest,
            'results' => $quotes
        ]);
    }
}
