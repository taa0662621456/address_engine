<?php
namespace App\Utility\AddressEngine\Validator;

use App\Utility\AddressEngine\Repository\CountryRepository;
use App\Utility\AddressEngine\Repository\SubdivisionRepository;
use App\Utility\AddressEngine\Repository\AddressFormatRepository;

final class AddressValidator
{
    public function __construct(
        private readonly CountryRepository       $countryRepo,
        private readonly SubdivisionRepository   $subdivisionRepo,
        private readonly AddressFormatRepository $formatRepo,
        private readonly ZipcodeValidator        $zipcodeValidator = new ZipcodeValidator()
    ) {}

    public function validate(array $data): array
    {
        $errors = [];

        // Country check
        if (empty($data['country']) || !$this->countryRepo->exists($data['country'])) {
            $errors[] = "Invalid or missing country";
        }

        // Subdivision check
        if (!empty($data['subdivision']) && !$this->subdivisionRepo->exists($data['country'], $data['subdivision'])) {
            $errors[] = "Invalid subdivision for country " . $data['country'];
        }

        // Zipcode check with validator
        if (empty($data['zipcode']) || !$this->zipcodeValidator->validate($data['country'] ?? '', $data['zipcode'])) {
            $errors[] = "Invalid or missing zipcode";
        }

        // City check
        if (empty($data['city'])) {
            $errors[] = "City is required";
        }

        // Street check
        if (empty($data['street']) || strlen($data['street']) < 2) {
            $errors[] = "Street is too short or missing";
        }

        return $errors;
    }

    public function isValid(array $data): bool
    {
        return count($this->validate($data)) === 0;
    }

    public function format(array $data): string
    {
        return $this->formatRepo->format($data['country'] ?? 'US', $data);
    }
}
