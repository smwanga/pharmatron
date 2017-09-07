<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Product;

class ProductsTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => (int) $product->id,
            'generic_name' => $product->generic_name,
            'category' => $product->category->category,
            'barcode' => (string) $product->barcode,
            'stock_code' => (string) $product->stock_code,
            'action' => '<a href="'.route('products.show', $product->id).'" class="btn btn-small btn-primary"><i class="glyphicon glyphicon-edit"></i> View</a>',
        ];
    }
}
