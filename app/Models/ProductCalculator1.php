<?php

namespace App\Models;

 
class ProductCalculator1 extends ProductCalculator 
{
 
    //returns product total sum
    public function getProductTotal($purchaseOrderProduct) {
        
        // $productTypeOneTotal = $productTypeOneTotal + ($product['unit_quantity_initial'] * $product['weight']);

        $this->unit_quantity_initial = $purchaseOrderProduct->unit_quantity_initial;
        $this->weight = $purchaseOrderProduct->weight;

        return $this->unit_quantity_initial * $this->weight;
        
    }

    
}
