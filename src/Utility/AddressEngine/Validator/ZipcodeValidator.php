<?php
namespace App\Utility\AddressEngine\Validator;

final class ZipcodeValidator
{
    private array $patterns = [
        'US' => '/^[0-9]{5}(-[0-9]{4})?$/',
        'DE' => '/^[0-9]{5}$/',
        'FR' => '/^[0-9]{5}$/',
        'UA' => '/^[0-9]{5}$/',
        'GB' => '/^[A-Z]{1,2}[0-9][0-9A-Z]? ?[0-9][A-Z]{2}$/'
    ];

    public function validate(string $country, string $zipcode): bool
    {
        $country = strtoupper($country);
        if (!isset($this->patterns[$country])) {
            return strlen($zipcode) > 0; // fallback basic check
        }
        return (bool)preg_match($this->patterns[$country], $zipcode);
    }
}
