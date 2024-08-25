<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;

 
class PurchaseOrderProduct 
{
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $product_type_id;
    protected $unit_quantity_initial;
    protected $volume;
    protected $weight;

    public function __construct($product_type_id)
    {
        $this->product_type_id  = $product_type_id;
    }

    public function getTotal() {
        $calculatorsConfig = $value = config('productcalculators');
        if (isset($calculatorsConfig['product_type_ids'][$this->product_type_id ])) {
            $class_path = '\\App\\Models\\' . (string)$calculatorsConfig['product_type_ids'][$this->product_type_id ];
            $ProductCalculator = new $class_path;
            return $ProductCalculator->getProductTotal($this);
        } else {
            //TODO handle generic types if needed
        }

 
    } 


}
