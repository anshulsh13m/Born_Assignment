<?php

class Product
{   
    /**
     *
     * @var ProductEntity 
     */
    public $productEntity;

    /**
     * Add Product Detail to Poduct Entity
     * 
     * @param String $productName ProductName
     * @param Float $unitPrice Product Price Per Unit
     * @param Array $volumePrice Product Volume Price By grouped Qty
     */
    public function addProductDetail($productName, $unitPrice, $volumePrice = array())
    {                
        if (!is_null($productName) && !is_numeric($productName)) {
            $unitPrice = floatval($unitPrice);
            $this->productEntity[$productName] =  ['unitPrice' => $unitPrice, 'volumePrice' => $volumePrice ];
        }
    }    
    
    /**
     * Check If the Product is available in product
     * @param string $productName productName
	 *
     * @return bool
     */
    public function isProductAvailable($productName)
	{
		if ($this->productEntity) {
			return array_key_exists($productName, $this->productEntity);
		}
    }
    
	/**
     * Update the Product Detail
	 *
     * @param String $productName ProductName
     * @param Float $unitPrice Product Price Per Unit
     * @param Array $volumePrice Product Volume Price By grouped Qty
     */
    public function updateProductDetail($productName, $unitPrice, $volumePrice = array())
    {
        $this->productEntity[$productName] =  ['unitPrice' => $unitPrice, 'volumePrice' => $volumePrice ];
    }
	
	
    /**
     * Get All Product Detail stored in Product Entity
     * 
     * @return Object Product
     */
    public function getProductDetail()
	{
        return $this->productEntity;
    }
}
