<?php
/**
 * @category   Emarsys
 * @package    Emarsys_Emarsys
 * @copyright  Copyright (c) 2016 Kensium Solution Pvt.Ltd. (http://www.kensiumsolutions.com/)
 */

namespace Emarsys\Emarsys\Model\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\ObserverInterface;

class CreditmemoSave implements ObserverInterface
{
    private $logger;

    protected $customerFactory;

    protected $orderQueueModel;

    protected $_responseFactory;

    protected $_url;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Emarsys\Emarsys\Model\OrderQueueFactory $orderQueueFactory,
        \Emarsys\Emarsys\Model\CreditmemoExportStatusFactory $creditmemoExportStatusFactory,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url
    ) {
    
        $this->logger = $logger;
        $this->_storeManager = $storeManager;
        $this->orderQueueFactory = $orderQueueFactory;
        $this->customerFactory = $customerFactory;
        $this->_responseFactory = $responseFactory;
        $this->creditmemoExportStatusFactory = $creditmemoExportStatusFactory;
        $this->_url = $url;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //echo "<pre>";
        //die('order id:'.$observer->getEvent()->getDataObject()->getOrder()->getId());
        //die(print_r($observer->getEvent()->getDataObject()->getOrder()));
        $creditmemoExportStatusData = $this->creditmemoExportStatusFactory->create()->getCollection()->addFieldToFilter('order_id', $observer->getEvent()->getDataObject()->getOrder()->getId());
        $orderExported = false;
        if (empty($creditmemoExportStatusData->getData())) {
            $creditmemoStatus = $this->creditmemoExportStatusFactory->create();
        } else {
            $creditmemoStatusData = $creditmemoExportStatusData->getData();
            $creditmemoStatus = $this->creditmemoExportStatusFactory->create()->load($creditmemoStatusData[0]['id']);
            if ($creditmemoStatus->getExported() == 1) {
                $orderExported = true;
            }
        }
        if ($orderExported == true) {
            return;
        }
        $creditmemoStatus->setOrderId($observer->getEvent()->getDataObject()->getOrder()->getId());
        $creditmemoStatus->setExported(0);
        $creditmemoStatus->setStatusCode($observer->getEvent()->getDataObject()->getOrder()->getStatus());
        $creditmemoStatus->save();
        $orderQueueData = $this->orderQueueFactory->create()->getCollection()->addFieldToFilter('entity_id', $observer->getEvent()->getDataObject()->getOrder()->getId())->addFieldToFilter('entity_type_id', 2);
        if (empty($orderQueueData->getData())) {
            $orderQueue = $this->orderQueueFactory->create();
        } else {
            $orderData = $orderQueueData->getData();
            $orderQueue = $this->orderQueueFactory->create()->load($orderData[0]['id']);
        }

        $orderQueue->setEntityId($observer->getEvent()->getDataObject()->getOrder()->getId());
        $orderQueue->setEntityTypeId(2);
        $orderQueue->setWebsiteId($observer->getEvent()->getDataObject()->getOrder()->getStore()->getWebsiteId());
        $orderQueue->setStoreId($observer->getEvent()->getDataObject()->getOrder()->getStoreId());
        $orderQueue->save();
    }
}
