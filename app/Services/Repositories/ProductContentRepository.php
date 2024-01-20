<?php

namespace App\Services\Repositories;

use App\Http\Resources\ProductResource;
use App\Models\ProductContent;
use App\Services\Interfaces\ProductContentInterface;
use App\Traits\ImageProcessingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class ProductContentRepository implements ProductContentInterface
{

    use ImageProcessingTrait;


    /**
     * @param int $productID
     *
     * @return ProductContent|null
     */
    private function getByProductId(int $productID): ?ProductContent
    {
        return ProductContent::query()->with('product')->whereProductId($productID)->first();
    }

    /**
     * @param int $id
     *
     * @return ProductContent|null
     */
    public function getById(int $id): ?ProductContent
    {
        return ProductContent::query()->with('product')->find(id: $id);
    }


    /**
     * @param int productID
     * @param Request $request
     *
     * @return ProductContent|null
     */
    public function create(int $productID, Request $request): ?ProductContent
    {
        $image = $this->imageUpload(file: $request->image, path: 'products', width: 1000, height: 1000);

        return ProductContent::query()->create([
            'product_id'      => $productID,
            'short_statement' => $request->short_statement,
            'statement'       => $request->statement,
            'price'           => $request->price,
            'image'           => $image['image'],
            'type'            => $image['type'],

        ]);
    }

    /**
     * @param int productID
     * @param Request $request
     *
     * @return bool
     */
    public function update(int $productID, Request $request): bool
    {

        $content = $this->getByProductId(productID: $productID);

        if (is_null($content)) return false;

        $result = false;

        if (!empty($request->image)) {
            $result = $this->deleteImage(image: $content->image, path: 'products');

            $image = $this->imageUpload(file: $request->image, path: 'products', width: 1000, height: 1000);
        }

        return ProductContent::query()->whereProductId($productID)->update([
            'short_statement' => $request->short_statement,
            'statement'       => $request->statement,
            'price'           => $request->price,
            'image'           => $result ? $image['image'] : $content->image,
            'type'            => $result ? $image['type'] : $content->type,

        ]);
    }


    /**
     * @param int productID
     * @param UploadedFile $image
     *
     * @return JsonResponse
     */
    public function updateImage(int $productID, UploadedFile $image): JsonResponse
    {
        $content = $this->getByProductId(productID: $productID);

        if (is_null($content)) {
            return response()->json(['message' => "Stoklarımızda Böyle Bir Ürün Bulunamadı !!!"], Response::HTTP_NOT_FOUND);
        }

        $result = $this->deleteImage(image: $content->image, path: 'products');

        if (!$result) {
            return response()->json(['message' => "Görsel Silme İşleminde Bir Sorun Oluştu Tekrar Deneyiniz !!!"], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $image = $this->imageUpload(file: $image, path: 'products', width: 1000, height: 1000);

        $content->update([
            'image' => $image['image'],
            'type'  => $image['type'],
        ]);

        return response()->json(["data" => ['product' => new ProductResource(resource: $content->product)], 'message' => "Ürün Görseli Başarıyla Güncellendi."], Response::HTTP_OK);
    }

    /**
     * @param int productID
     *
     * @return bool
     */
    public function productContentDeleteImage(int $productID): bool
    {
        $content = $this->getByProductId(productID: $productID);

        if (is_null($content)) return false;

        return $this->deleteImage(image: $content->image, path: 'products');
    }
}
