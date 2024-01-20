<?php

namespace App\Services\Interfaces;

use App\Enums\StatusEnum;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ProductInterface extends BaseInterface
{

    /**
     * @param int $paginate
     *
     * @return LengthAwarePaginator
     */
    public function getPaginationProducts(int $paginate = 10): LengthAwarePaginator;

    /**
     * @param StatusEnum $status
     * @param int $paginate
     *
     * @return LengthAwarePaginator
     */
    public function getByStatusPaginationProducts(StatusEnum $status, int $paginate = 10): LengthAwarePaginator;


    /**
     * @param int $paginate
     *
     * @return Product|null
     */
    public function getByActiveId(int $id): ?Product;

    /**
     * @param int $paginate
     *
     * @return JsonResponse
     */
    public function getlistAll(int $paginate = 10): JsonResponse;

    /**
     * @param StatusEnum $status
     * @param int $paginate
     *
     * @return JsonResponse
     */
    public function getByStatusList(StatusEnum $status, int $paginate = 10): JsonResponse;

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse;

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse;

    /**
     * @param int productID
     *
     * @return JsonResponse
     */
    public function delete(int $productID): JsonResponse;

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse;

    /**
     * @param int productID
     * @param string $status
     *
     * @return JsonResponse
     */
    public function updateStatus(int $productID, string $status): JsonResponse;
}
