<?php

namespace App\Services\Interfaces;

use App\Models\ProductContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface ProductContentInterface extends BaseInterface
{
    /**
     * @param int productID
     * @param Request $request
     *
     * @return ProductContent|null
     */
    public function create(int $productID, Request $request): ?ProductContent;


    /**
     * @param int productID
     * @param Request $request
     *
     * @return bool
     */
    public function update(int $productID, Request $request): bool;


    /**
     * @param int productID
     * @param UploadedFile $image
     *
     * @return JsonResponse
     */
    public function updateImage(int $productID, UploadedFile $image): JsonResponse;


    /**
     * @param int productID
     *
     * @return bool
     */
    public function productContentDeleteImage(int $productID): bool;
}
