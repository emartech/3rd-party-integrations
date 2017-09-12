<?php
/**
 * @category   Emarsys
 * @package    Emarsys_Emarsys
 * @copyright  Copyright (c) 2016 Kensium Solution Pvt.Ltd. (http://www.kensiumsolutions.com/)
 */

namespace Emarsys\Emarsys\Block\Adminhtml\Customerexport;

use Magento\Backend\Block\Widget\Form\Container;
use Emarsys\Emarsys\Controller\Adminhtml\Customerexport;

class Form extends \Magento\Backend\Block\Widget\Form
{
    protected $_template = 'bulkexport/bulkexport.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
    
        parent::__construct($context, $data);
        $this->setId('customerExportForm');
    }

    protected function _beforeToHtml()
    {
        $this->isFromError = $this->getRequest()->getParam('error') === 'true';
        return parent::_beforeToHtml();
    }

    public function getStoreId()
    {
        $storeId = $this->getRequest()->getParam('store');
        return $storeId;
    }
}
