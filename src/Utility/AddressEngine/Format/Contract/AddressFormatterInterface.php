<?php
declare(strict_types=1);

namespace App\Utility\AddressEngine\Format\Contract;

use App\Entity\Address\Address;

interface AddressFormatterInterface
{
    public function format(Address $address): string;
}
