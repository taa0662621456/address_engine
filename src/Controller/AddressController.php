<?php
namespace App\Controller;

use App\Application\Address\AddressService;
use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\PagedResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address')]
final class AddressController extends AbstractController
{
    public function __construct(private readonly AddressService $service) {}

    #[Route('', name: 'address_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dto = new AddressDTO(
            $data['city'] ?? '',
            $data['country'] ?? '',
            $data['street'] ?? '',
            $data['zipcode'] ?? ''
        );

        $this->service->createFromDTO($dto);

        return new JsonResponse(['status' => 'created'], 201);
    }

    #[Route('/{id}', name: 'address_get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $dto = $this->service->getResponseDTO($id);
        if (!$dto) {
            return new JsonResponse(['error' => 'Not found'], 404);
        }
        return new JsonResponse($dto);
    }

    #[Route('/search', name: 'address_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $city = $request->query->get('city');
        $results = $this->service->searchByCity($city ?? '');
        return new JsonResponse(array_map(
            fn($a) => (array)$a,
            $results
        ));
    }

    #[Route('/list', name: 'address_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $page = (int)$request->query->get('page', 1);
        $limit = (int)$request->query->get('limit', 10);
        $paged = $this->service->paginateResponse($page, $limit);

        return new JsonResponse([
            'items' => $paged->items,
            'total' => $paged->total,
            'page' => $paged->page,
            'limit' => $paged->limit
        ]);
    }

    #[Route('/search-advanced', name: 'address_search_advanced', methods: ['POST'])]
    public function searchAdvanced(Request $request): JsonResponse
    {
        $criteria = json_decode($request->getContent(), true);
        $page = (int)($criteria['page'] ?? 1);
        $limit = (int)($criteria['limit'] ?? 10);

        $paged = $this->service->searchAdvanced($criteria, $page, $limit);

        return new JsonResponse([
            'items' => $paged->items,
            'total' => $paged->total,
            'page' => $paged->page,
            'limit' => $paged->limit
        ]);
    }
}
