<?php
declare(strict_types=1);

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($aisleId, $productId)
    {
        // Assuming aisleId is not required for fetching the product, just the productId
        $product = Product::find($productId);

        if ($product) {
            return response()->json([
                'name' => $product->name,
                'kind' => $product->kind,
                'price' => $product->price,
            ]);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }
}
?>