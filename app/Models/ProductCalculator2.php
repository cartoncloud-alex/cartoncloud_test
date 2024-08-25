<?php

namespace App\Models;

 
class ProductCalculator1 extends ProductCalculator 
{
 
    //returns product total sum
    public function getProductTotal($purchaseOrderProduct) {
        
        // $productTypeTwoTotal = $productTypeTwoTotal + ($product['unit_quantity_initial'] * $product['volume']);

        $this->unit_quantity_initial = $purchaseOrderProduct->unit_quantity_initial;
        $this->volume = $purchaseOrderProduct->volume;

        return $this->unit_quantity_initial * $this->volume;
        
    }

    
}
