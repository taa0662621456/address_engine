<?php
namespace App\Utility\AddressEngine\Format\Strategy;


class AuFormatter implements AuAddressFormatInterface
{
    use ObjectAuditTrait;
    public static function normalize(array $data): array
    {
        // Australian postcodes are 4 digits
        $data['postal_code'] = substr(preg_replace('/\D+/', '', (string)($data['postal_code'] ?? '')), 0, 4);
        return $data;
    }
}
