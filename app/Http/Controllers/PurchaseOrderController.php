<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderTotalsRequest;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PurchaseOrderProduct;

class PurchaseOrderController extends Controller
{
    /**
     * generate purchase order totals
     *
     * @param  Request $request
     */
    public function purchaseOrderTotals(PurchaseOrderTotalsRequest $request)
    {
        $responses = [];
        foreach ($request->purchase_order_ids as $purchaseOrderId) {
            //$responses[] = Http::withBasicAuth('interview-test@cartoncloud.com.au', 'test123456')->get('https://api.cartoncloud.com.au/CartonCloud_Demo/' . $purchaseOrderId . '?version=5&associated=true');
            $responses[] = Http::withBasicAuth(env('API_USER', 'interview-test@cartoncloud.com.au'), env('API_PW', 'test123456'))
            ->get('https://api.cartoncloud.com.au/CartonCloud_Demo/' . $purchaseOrderId . '?version=5&associated=true')
            ->timeout(2);
        }

        //$grouped = []; //not used 
 
        $productTotals = [];
        foreach ($responses as $response) {
            $json = $response->json();

            if (isset($json['data']['PurchaseOrderProduct'])) {
                $products = $json['data']['PurchaseOrderProduct'];

                foreach ($products as $product) {
                    if (isset($product['product_type_id'])) {
                        $product = new PurchaseOrderProduct($product['product_type_id']);
                        $productTotals[$product['product_type_id']] +=  $product->getTotal();
                    }
                }
            }

        }

        $result = [];

        foreach ($productTotals as $productTypeID => $productTotal) {
            $result[] = [
                'product_type_id'=> $productTypeID,
                'total' => $productTotal,
            ];
        }

        return response()->json([
            'result' => $result
        ]);
    }
}
