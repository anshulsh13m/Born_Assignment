<?php

namespace Born\OrderController\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class Data extends AbstractHelper
{
	/**
     *
     * @var Object SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;
	
	/**
     * @var Object OrderItemRepositoryInterface
     */
    protected $_orderItemRepository;
	
	/**
     * @var Object OrderRepositoryInterface 
     */
    protected $_orderRepository;
	
	/**
     * 
     * @param Context $context
	 * @param SearchCriteriaBuilder $searchCriteriaBuilder
	 * @param OrderItemRepositoryInterface $orderItemRepository
	 * @param OrderRepositoryInterface $orderRepository
     */
	public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_orderItemRepository = $orderItemRepository;
		$this->_orderRepository = $orderRepository;
        parent::__construct($context);
    }
	
	/**
     * Get the Guest Order details
     * 
	 * @param int $orderId
     * @return array
     */
    public function getGuestOrderData($orderId)
    {
		$guestOrderData = [];
		$searchCriteriaForGuestOrder = $this->_searchCriteriaBuilder
											->addFilter('increment_id', $orderId, 'eq')
											->addFilter('customer_is_guest', '1')
											->create();
		$orderList = $this->_orderRepository->getList($searchCriteriaForGuestOrder);
		
		if ($orderList->getSize()) {
			foreach($orderList->getData() as $orderdata){
				$guestOrderData['order_id'] = $orderdata['entity_id'];
				$guestOrderData['order_status'] = $orderdata['status'];
				$guestOrderData['total'] = $orderdata['grand_total'];
			}
				
			if (isset($guestOrderData['order_id']) && $guestOrderData['order_id']) {
				$searchCriteriaForOrderItem = $this->_searchCriteriaBuilder
													->addFilter('order_id', $guestOrderData['order_id'], 'eq')
													->create();
				$orderItemList = $this->_orderItemRepository->getList($searchCriteriaForOrderItem);
				$items = 1;
				foreach($orderItemList as $itemdata){
					$guestOrderData['items'][$items]['sku'] = $itemdata['sku'];
					$guestOrderData['items'][$items]['item_id'] = $itemdata['item_id'];
					$guestOrderData['items'][$items]['price'] = $itemdata['price'];
					$items++;
				}
			}
		}
		return $guestOrderData;
    }
}