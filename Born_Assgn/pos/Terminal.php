<?php

include 'Checkout/Cart.php';
include 'Catalog/Product.php';

class Terminal
{
    /**
     *
     * @var Checkout/Cart 
     */
    protected $_cart;

    /**
     *
     * @var Catalog/Product 
     */
    protected $_product;

    /**
     * Consructor
     * 
     */
    public function __construct()
	{
        $this->_cart = new Cart();
        $this->_product = new Product();
    }
   
    /**
     * Add product detail
     * 
     */
    public function addProductDetail($productName = null, $unitPrice = null, $volumnPrice=array())
	{  
        if(!$this->_product->isProductAvailable($productName)){
           $this->_product->addProductDetail($productName, $unitPrice, $volumnPrice);
        }
    }
    
    /**
     * set Product Price 
     */
    public function setProductPrice($productName = null, $unitPrice = null, $volumnPrice=array())
    {
        if($this->_product->isProductAvailable($productName)){
            $this->_product->updateProductDetail($productName, $unitPrice, $volumnPrice);
        }
    }
	
    /**
     * Scan product by taking input
     *  
     * @param string $products
     */
    public function scan($products)
	{
        $productLength = strlen($products);
        $productArr = str_split($products);
		
        for ($product = 0; $product < $productLength; $product++) {
            try {
				if (!is_numeric($productArr[$product])) {
					$this->_cart->addToCart($productArr[$product]);
				} else {
					throw new Exception;
				}
            } catch (Exception $e) {
                $product++;
                echo "'$product' th product is invalid, will not calculate price. <br>";
            }
            echo PHP_EOL;
        }
        echo '<br> Total Price is : $' . number_format((float)$this->_cart->calculateTotalPrice($this->_product), 2, '.', '') . '<br>';
    }
}
