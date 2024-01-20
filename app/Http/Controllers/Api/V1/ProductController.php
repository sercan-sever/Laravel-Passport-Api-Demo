<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductCreateRequest;
use App\Http\Requests\Api\V1\ProductImageUpdateRequest;
use App\Http\Requests\Api\V1\ProductStatusUpdateRequest;
use App\Http\Requests\Api\V1\ProductUpdateRequest;
use App\Services\Interfaces\ProductContentInterface;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @param ProductInterface $product
     * @param ProductContentInterface $content
     *
     * @return void
     */
    public function __construct(
        private ProductInterface $product,
        private ProductContentInterface $content
    ) {
        //
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productListAll(Request $request): JsonResponse
    {
        return $this->product->getlistAll(paginate: 10);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productListActive(Request $request): JsonResponse
    {
        return $this->product->getByStatusList(status: StatusEnum::A);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productListPassive(Request $request): JsonResponse
    {
        return $this->product->getByStatusList(status: StatusEnum::P);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function productDetail(int $id): JsonResponse
    {
        return $this->product->detail(id: $id);
    }

    /**
     * @param ProductCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(ProductCreateRequest $request): JsonResponse
    {
        return $this->product->create(request: $request);
    }


    /**
     * @param ProductUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request): JsonResponse
    {
        return $this->product->update(request: $request);
    }

    /**
     * @param ProductStatusUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateStatus(ProductStatusUpdateRequest $request): JsonResponse
    {
        return $this->product->updateStatus(productID: $request->validated('productID'), status: $request->validated('status'));
    }

    /**
     * @param ProductImageUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateImage(ProductImageUpdateRequest $request): JsonResponse
    {
        return $this->content->updateImage(productID: $request->validated('productID'), image: $request->validated('image'));
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function productDelete(int $id): JsonResponse
    {
        return $this->product->delete(productID: $id);
    }
}
