<?php

namespace Dispatch\SalesChannel\Block\Adminhtml\System\Config\Fieldset;

use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\Template;
use Magento\Framework\Module\Dir\Reader as DirReader;

class Extension extends Template implements RendererInterface
{
    protected $dirReader;

    public function __construct(
        DirReader $dirReader,
        Template\Context $context,
        \Magento\Framework\HTTP\Client\Curl $curl,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->dirReader = $dirReader;
        $this->_curl     = $curl;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '';
        if ($element->getData('group')['id'] == 'extension_info') {
            $html = $this->toHtml();
        }
        return $html;
    }

    public function getTemplate()
    {
        return 'Dispatch_SalesChannel::system/config/fieldset/extension.phtml';
    }
}
