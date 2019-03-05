<?php

class Cart
{
	/**
     *
     * @var type Quote 
     */
    protected $_quote;
    
    /**
     * Add Product to cart
     * And Count Already Exist product in Quote
     * 
     * @param string $productName
     */
    public function addToCart($productName)
	{
		if ($this->isAlreadyInQuote($productName)) {
			$this->_quote[$productName] ++;
		} else {
			$this->_quote[$productName] = 1;
		}
    }

    /**
     * Check product already exists in Quote
     * 
     * @param string $productName
     * @return Bool TRUE|FALSE
     */
    public function isAlreadyInQuote($productName)
	{
		if ($this->_quote) {
			return array_key_exists($productName, $this->_quote);
		}
    }

    /**
     * Calculate Total Price
     * 
     * @param Object $product
     * @return FLOAT
     * 
     */
    public function calculateTotalPrice($product)
	{
        $totalPrice = 0;
		if ($this->_quote) {
			foreach ($this->_quote as $productName => $productCount) {
				$totalPrice += $this->calculate($productName, $productCount, $product);
			}
		}
        
        return $totalPrice;
    }

    /**
     * Calculate Unit and Volume Price seperately
	 *
     * @param String $productName ProductName
     * @param Int $productCount ProductCount
     * @param Object $product
	 *
     * @return FLOAT
     */
    public function calculate($productName, $productCount, $product) {
        $totalVolumnPrice = 0.00;
        $remainingProduct = $productCount;
        $productEntity = $product->getProductDetail();

        $isVolumePrdAndData = $this->isVolumeProduct($productName, $productEntity);
        if (!empty($isVolumePrdAndData)) {
            $volumnProCal = $this->calculateVolumePrice($productCount, $isVolumePrdAndData);
            $totalVolumnPrice = $volumnProCal[0];
            $remainingProduct = $volumnProCal[1];
        }

        $productUnitPrice = $this->getUnitPrice($productName, $productEntity);
        $totalUnitPrice = $this->calculateUnitPrice($remainingProduct, $productUnitPrice);

        return $totalVolumnPrice + $totalUnitPrice;
    }
    
    /**
     * Calculate Volume Price
     * 
     * @param int $product_count
     * @param Array $isVolumePrdAndData
     * @return Array
     */
    private function calculateVolumePrice($product_count, $isVolumePrdAndData)
	{
        /**
		 * Count total Volume for product
		 */
        $volume_counts = array_keys($isVolumePrdAndData);
        $totalVolume = $this->totalVolume($product_count, $volume_counts);
        $total = 0.00;

        while ($totalVolume != -1 && $product_count != 0) {
            if ($totalVolume > $product_count) {
                $totalVolume = $this->totalVolume($product_count, $volume_counts);
            } else if (($product_count - $totalVolume) >= 0) {
                $product_count = $product_count - $totalVolume;
                $total += $isVolumePrdAndData[$totalVolume];
            }
        }

        return array($total, $product_count);
    }

    /**
     * Calculate Unit Price
     * 
     * @param int $product_count
     * @param FLOAT $unit_price
     * @return FLOAT
     */
    private function calculateUnitPrice($product_count, $unit_price)
	{
        return $product_count * $unit_price;
    }

    /**
     * 
     * Get the Volume and Unit qty of Product
     * 
     * @param type $total
     * @param type $volumes
     * @return type
     */
    private function totalVolume($total, $volumes) {
        $total_diff = $total;
        $ramaining_vol = $volumes[0];

        foreach ($volumes as $volume) {
            $diff = abs($total - $volume);

            if ($diff < $total_diff && $total >= $volume) {
                $total_diff = $diff;
                $ramaining_vol = $volume;
            }
        }
        if ($ramaining_vol > $total) {
            return -1;
        }

        return $ramaining_vol;
    }

    
    /**
     * Check If Volume Product
     * 
     * @param String $productName
     * @param Array $productEntity
     * @return Array
     */
    public function isVolumeProduct($productName, $productEntity)
	{	
		foreach ($productEntity as $entity => $value) {
			if ($entity == $productName) {
				return $productEntity[$productName]['volumePrice'];
			}
		}
    }

    /**
     * Get Unit price of Product
     * 
     * @param Sring $productName
     * @param Array $productEntity
     * @return Float|INT
     */
    public function getUnitPrice($productName, $productEntity)
	{
		foreach ($productEntity as $entity => $value) {
			if ($entity == $productName) {
				return $productEntity[$productName]['unitPrice'];
			}
		}
    }
}
