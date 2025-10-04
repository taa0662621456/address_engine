<?php
namespace App\Utility\AddressEngine\Format\Strategy;

class CaFormatter implements CaAddressFormatInterface
{
    use ObjectAuditTrait;
    public static function normalize(array $data): array
    {
        // Canadian postal code format A1A 1A1
        $pc = strtoupper((string)($data['postal_code'] ?? ''));
        $pc = preg_replace('/[^A-Z0-9]/', '', $pc);
        $pc = substr($pc,0,3). ' ' . substr($pc,3,3);
        $data['postal_code'] = trim($pc);
        return $data;
    }
}
