<?php
namespace App\Utility\AddressEngine\Format\Strategy;

class UaFormatter implements UaAddressFormatInterface
{
    use ObjectAuditTrait;
    // region-specific validation/mapping helpers
    public static function normalize(array $data): array
    {
        // expects keys: region (oblast), district (raion), city, street, house, postal_code
        $data['postal_code'] = preg_replace('/\D+/', '', (string)($data['postal_code'] ?? ''));
        return $data;
    }
}
