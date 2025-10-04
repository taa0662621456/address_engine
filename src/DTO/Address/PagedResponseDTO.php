<?php
namespace App\Application\Address\DTO;

final class PagedResponseDTO
{
    /**
     * @param array $items список DTO (например, AddressResponseDTO[])
     * @param int $total общее количество элементов
     * @param int $page текущая страница
     * @param int $limit количество элементов на страницу
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $limit
    ) {}
}
