<?php

namespace App\Service\Shipping;

interface ShippingProviderInterface
{
    /**
     * Devuelve el slug único del proveedor (ej: 'dhl_mock', 'fedex_mock')
     */
    public function getProviderSlug(): string;

    /**
     * Realiza la cotización
     */
    public function quote(string $originZip, string $destZip, string $url): array;
}
