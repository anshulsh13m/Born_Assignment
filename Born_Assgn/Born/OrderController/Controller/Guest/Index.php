<?php

namespace Born\OrderController\Controller\Guest;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Born\OrderController\Helper\Data as orderHelper;

class Index extends Action
{
	/**
     *
     * @var orderHelper
     */
	protected $_orderHelper;
	
    /**
     * 
     * @param Context $context
	 * @param orderHelper $orderHelper
     */
    public function __construct(
        Context $context,
		orderHelper $orderHelper
    ) {
		$this->_orderHelper = $orderHelper;
        parent::__construct($context);
    }

    /**
     * Get the Guest Order details
     * 
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $params = $this->_request->getParams();
            $orderId = (isset($params['order_id']) && $params['order_id']) ? $params['order_id'] : '';
            if (isset($orderId) && $orderId) {
				$guestOrderjson = [];
				$guestOrderData = $this->_orderHelper->getGuestOrderData($orderId);
				if (empty($guestOrderData)) {
					$guestOrderjson['result'] = 'No Record Found';
				} else {
					$guestOrderjson['result'] = $guestOrderData;
				}
				$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
				return $resultJson->setData($guestOrderjson);
            }
			$guestOrderjson['result'] = 'No Record Found';
			return;
        }
    }
}