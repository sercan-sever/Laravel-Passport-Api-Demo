<?php

namespace App\Services\Repositories;

use App\Enums\StatusEnum;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Interfaces\ProductInterface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductRepository implements ProductInterface
{
    /**
     * @param int $paginate
     *
     * @return LengthAwarePaginator
     */
    public function getPaginationProducts(int $paginate = 10): LengthAwarePaginator
    {
        return Product::query()->with(['user', 'content'])->paginate(perPage: $paginate);
    }


    /**
     * @param StatusEnum $status
     * @param int $paginate
     *
     * @return LengthAwarePaginator
     */
    public function getByStatusPaginationProducts(StatusEnum $status, int $paginate = 10): LengthAwarePaginator
    {
        return Product::query()->with(['content', 'user'])->whereStatus($status)->paginate(perPage: $paginate);
    }


    /**
     * @param int $paginate
     *
     * @return Product|null
     */
    public function getByActiveId(int $id): ?Product
    {
        return Product::query()->whereStatus(StatusEnum::A)->find(id: $id);
    }


    /**
     * @param int $paginate
     *
     * @return Product|null
     */
    public function getById(int $id): ?Product
    {
        return Product::query()->find(id: $id);
    }


    /**
     * @param int $paginate
     *
     * @return JsonResponse
     */
    public function getlistAll(int $paginate = 10): JsonResponse
    {
        $products = $this->getPaginationProducts(paginate: $paginate);

        return $products->isNotEmpty()
            ? ProductResource::collection(resource: $products)->response()
            : response()->json(['data' => []], Response::HTTP_OK);
    }


    /**
     * @param StatusEnum $status
     * @param int $paginate
     *
     * @return JsonResponse
     */
    public function getByStatusList(StatusEnum $status, int $paginate = 10): JsonResponse
    {
        $products = $this->getByStatusPaginationProducts(status: $status, paginate: $paginate);

        return $products->isNotEmpty()
            ? ProductResource::collection(resource: $products)->response()
            : response()->json(['data' => []], Response::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        $product = $this->getByActiveId(id: $id);

        return !is_null($product)
            ? response()->json(["data" => ['product' => new ProductResource(resource: $product)], 'message' => "Ürün Mevcut"], Response::HTTP_OK)
            : response()->json(['message' => "Böyle Bir Ürün Stoklarımızda Bulunamadı !!!"], Response::HTTP_NOT_FOUND);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $product = Product::query()->create([
            'user_id' => auth()->id(),
            'name'    => $request->validated('name'),
            'slug'    => str($request->validated('name'))->slug(),
            'status'  => $request->validated('status'),
        ]);

        return response()->json(["data" => ['product' => new ProductResource(resource: $product)], 'message' => "Ürün Başarıyla Yüklendi."], Response::HTTP_OK);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $product = $this->getById(id: $request->validated('productID'));

        if (empty($product))
            return response()->json(['message' => "Stoklarımızda Böyle Bir Ürün Bulunamadı !!!"], Response::HTTP_NOT_FOUND);


        $product->update([
            'user_id' => auth()->id(),
            'name'    => $request->validated('name'),
            'slug'    => str($request->validated('name'))->slug(),
            'status'  => $request->validated('status'),
        ]);

        return response()->json(["data" => ['product' => new ProductResource(resource: $product)], 'message' => "Ürün Başarıyla Güncellendi."], Response::HTTP_OK);
    }

    /**
     * @param int productID
     *
     * @return JsonResponse
     */
    public function delete(int $productID): JsonResponse
    {
        $product = $this->getById(id: $productID);

        if (empty($product))
            return response()->json(['message' => "Stoklarımızda Böyle Bir Ürün Bulunamadı !!!"], Response::HTTP_NOT_FOUND);


        return (bool)$product->delete()
            ? response()->json(['message' => "Ürün Başarıyla Silindi."], Response::HTTP_OK)
            : response()->json(['message' => "Üreün Silme İşleminde Bir Sorun Oluştu Lütfen Tekrar Deneyiniz !!!"], Response::HTTP_METHOD_NOT_ALLOWED);
    }



    /**
     * @param int productID
     * @param string $status
     *
     * @return JsonResponse
     */
    public function updateStatus(int $productID, string $status): JsonResponse
    {
        $product = $this->getById(id: $productID);

        if (empty($product))
            return response()->json(['message' => "Stoklarımızda Böyle Bir Ürün Bulunamadı !!!"], Response::HTTP_NOT_FOUND);


        if ($product->status->value ===  $status)
            return response()->json(['message' => "Ürün Durumu Ve Gönderilen Durum Aynı Olduğu İçin Bir Değişiklik Yapılamadı !!!"], Response::HTTP_METHOD_NOT_ALLOWED);


        $product->update([
            'status' => $status
        ]);

        return response()->json(["data" => ['product' => new ProductResource(resource: $product)], 'message' => "Ürün Durumu Başarıyla Güncellendi."], Response::HTTP_OK);
    }
}
