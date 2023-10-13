<?php

namespace Dispatch\SalesChannel\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * TestConnection frontend model model for button.
 */
class TestConnection extends Field
{
    /**
     * Path to the template file for the button.
     *
     * @var string
     */
    protected $_template = 'Dispatch_SalesChannel::system/config/button.phtml';

    /**
     * TestConnection constructor.
     *
     * @param Context $context
     * @param array   $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Render the button element.
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get the URL for the Ajax check.
     *
     * @return string
     */
    public function getAjaxCheckUrl()
    {
        return $this->getUrl('saleschannel/config/testConnection');
    }
}
