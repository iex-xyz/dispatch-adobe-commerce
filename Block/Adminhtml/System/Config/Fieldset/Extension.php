<?php

namespace Dispatch\SalesChannel\Block\Adminhtml\System\Config\Fieldset;

use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * Extension frontend model for extension info.
 */
class Extension extends Template implements RendererInterface
{
    /**
     * Render element.
     *
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

    /**
     * Path to the template file for the extension info.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Dispatch_SalesChannel::system/config/fieldset/extension.phtml';
    }
}
