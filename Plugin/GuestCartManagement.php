<?php

namespace Dispatch\SalesChannel\Plugin;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;

/**
 * Class GuestCartManagement
 *
 * This class is responsible for modifying an empty cart after it's created in a Magento sales channel plugin.
 */
class GuestCartManagement
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var MaskedQuoteIdToQuoteIdInterface
     */
    protected $maskedQuoteIdToQuoteId;

    /**
     * GuestCartManagement constructor.
     *
     * @param Request $request
     * @param CartRepositoryInterface $cartRepository
     * @param MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId
     */
    public function __construct(
        Request $request,
        CartRepositoryInterface $cartRepository,
        MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId
    ) {
        $this->request = $request;
        $this->cartRepository = $cartRepository;
        $this->maskedQuoteIdToQuoteId = $maskedQuoteIdToQuoteId;
    }

    /**
     * Modify an empty cart after it's created.
     *
     * @param mixed $result
     * @param string $quoteIdMask
     * @return string
     */
    public function afterCreateEmptyCart($result, $quoteIdMask)
    {
        try {
            $body = $this->request->getBodyParams();

            // Check if 'data' and 'order_via_dispatch' exist in the body.
            if (isset($body['data']['order_via_dispatch'])) {
                $isDispatchOrder = $body['data']['order_via_dispatch'];

                $cartId = $this->maskedQuoteIdToQuoteId->execute($quoteIdMask);
                $quote = $this->cartRepository->get($cartId);

                // Set the 'order_via_dispatch' attribute and save the quote.
                $quote->setData('order_via_dispatch', $isDispatchOrder)->save();
            }
        } catch (\Exception $e) {
            error_log("\n" . $e->getMessage(), 3, BP . "/var/log/Dispatch_SalesChannel_Error.log");
        }
        return $quoteIdMask;
    }
}
