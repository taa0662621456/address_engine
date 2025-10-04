<?php
namespace App\Utility\AddressEngine\Format;


use App\Utility\AddressEngine\Format\Factory\AddressFormatterFactory;

final class AddressFormatter
{
    private AddressFormatterFactory $factory;

    public function __construct(?AddressFormatterFactory $factory = null)
    {
        $this->factory = $factory ?? new AddressFormatterFactory();
    }

    /**
     * Форматирует адрес для заданной страны по данным массива
     *
     * @param string $country Код страны (например "UA", "US", "CA")
     * @param array $data Поля: street, city, subdivision?, zipcode, country
     * @return string
     */
    public function format(string $country, array $data): string
    {
        $strategy = $this->factory->create($country);
        return $strategy->format($data);
    }
}
