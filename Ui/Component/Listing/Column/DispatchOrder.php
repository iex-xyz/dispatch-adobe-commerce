<?php

namespace Dispatch\SalesChannel\Ui\Component\Listing\Column;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class DispatchOrder
 *
 * This class represents a custom column in the Magento admin order grid that displays
 * whether an order was placed via the Dispatch Sales Channel. It fetches data from
 * the 'order_via_dispatch' attribute and displays it as "Yes" or "No" in the column.
 */
class DispatchOrder extends Column
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * DispatchOrder Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepares data of column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $order = $this->_orderRepository->get($item["entity_id"]);

                $isDispatchOrder = $order->getData("order_via_dispatch");

                // Map the attribute value to a user-friendly "Yes" or "No" string
                switch ($isDispatchOrder) {
                    case "1":
                        $isDispatchOrder = "Yes";
                        break;
                    case "0":
                    default:
                        $isDispatchOrder = "No";
                        break;
                }

                // Set the column value with the "Yes" or "No" string
                $item[$this->getData('name')] = $isDispatchOrder;
            }
        }

        return $dataSource;
    }
}
