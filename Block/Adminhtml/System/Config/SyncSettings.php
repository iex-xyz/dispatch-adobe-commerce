<?php

namespace Dispatch\SalesChannel\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\UrlInterface;

/**
 * SyncSettings frontend model model for button.
 */
class SyncSettings extends Field
{
    /**
     * Path to the template file for the button.
     *
     * @var string
     */
    protected $_template = 'Dispatch_SalesChannel::system/config/sync_button.phtml';

    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * SyncSettings constructor.
     *
     * @param Context      $context
     * @param UrlInterface $urlInterface
     * @param array        $data
     */
    public function __construct(
        Context $context,
        UrlInterface $urlInterface,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlInterface = $urlInterface;
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

    /**
     * Get HTML for the element.
     *
     * @param AbstractElement $element
     * @return string
     */
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
        $url        = $this->urlInterface->getCurrentUrl();
        $matches    = [];
        $storeParam = "";
        if (preg_match('/store\/(\d+)/', $url, $matches)) {
            $storeParam = $matches[1];
        }
        return $this->getUrl('saleschannel/config/syncSettings', ['store' => $storeParam]);
    }
}
