<?php

namespace Dispatch\SalesChannel\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class QuoteSubmitBefore
 * It copies the 'order_via_dispatch' data from the quote to the order before order placement.
 */
class QuoteSubmitBefore implements ObserverInterface
{
    /**
     * Execute the observer logic
     *
     * @param Observer $observer The event observer object
     */
    public function execute(Observer $observer)
    {
        $quote = $observer->getData('quote');
        $order = $observer->getData('order');

        // Copy the 'order_via_dispatch' data from the quote to the order
        $order->setData('order_via_dispatch', $quote->getData('order_via_dispatch'));
    }
}
