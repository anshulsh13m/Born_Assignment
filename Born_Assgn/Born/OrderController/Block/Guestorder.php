<?php

namespace Born\OrderController\Block;

use Magento\Framework\View\Element\Template\Context;

class Guestorder extends \Magento\Framework\View\Element\Template
{
    /**
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
		Context $context,
		array $data = []
    ) {
        parent::__construct($context, $data);
    }
    
    /**
     * Guest Order Url
     * 
     * @return string URL
     */
    public function getGuestOrderUrl()
    {
        return $this->getUrl("guest/guest");
    }
}
