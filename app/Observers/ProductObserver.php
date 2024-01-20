<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Interfaces\ProductContentInterface;

class ProductObserver
{
    /**
     * @param ProductContentInterface $productContent
     *
     * @return void
     */
    public function __construct(private ProductContentInterface $productContent)
    {
        //
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->productContent->create(productID: $product->id, request: request());
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if (in_array('slug', collect($product->getChanges())->keys()->toArray()))
        {
            $this->productContent->update(productID: $product->id, request: request());
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleting" event.
     */
    public function deleting(Product $product): void
    {
        $this->productContent->productContentDeleteImage(productID: $product->id);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
