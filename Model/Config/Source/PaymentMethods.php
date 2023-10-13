<?php

namespace Dispatch\SalesChannel\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Payment\Model\Config as PaymentConfig;

/**
 * PaymentMethods source model for payment method configuration options.
 */
class PaymentMethods implements ArrayInterface
{
    /**
     * @var PaymentConfig
     */
    protected $paymentConfig;

    /**
     * PaymentMethods constructor.
     *
     * @param PaymentConfig $paymentConfig
     */
    public function __construct(
        PaymentConfig $paymentConfig
    ) {
        $this->paymentConfig = $paymentConfig;
    }

    /**
     * Convert active payment methods to an option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $methods = $this->paymentConfig->getActiveMethods();
        $enabledMethods = [];

        foreach ($methods as $method) {
            $enabledMethods[] = [
                'value' => $method->getCode(),
                'label' => $method->getTitle()
            ];
        }
        array_unshift($enabledMethods, ['value' => 0, 'label' => '-- Please Select --']);

        return $enabledMethods;
    }
}