<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;


use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddPaymentInfo;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddShippingInfo;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\BeginCheckout;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Purchase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class CheckoutEventFactory
{
    private CartContextInterface $cartContext;
    private ItemFactory $itemFactory;

    /**
     * @param CartContextInterface $cartContext
     * @param ItemFactory $itemFactory
     */
    public function __construct(CartContextInterface $cartContext, ItemFactory $itemFactory)
    {
        $this->cartContext = $cartContext;
        $this->itemFactory = $itemFactory;
    }

    public function beginCheckout(): BeginCheckout
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();

        $beginCheckout = new BeginCheckout();
        $beginCheckout->setCoupon(implode(', ', $this->getCoupons($order)));

        $this->addItems($beginCheckout);
        return $beginCheckout;
    }

    public function addPaymentInfo(): AddPaymentInfo
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        /** @var PaymentInterface|null $lastPayment */
        $lastPayment = $order->getLastPayment();


        $addPayment = new AddPaymentInfo();
        $addPayment->setCoupon(implode(', ', $this->getCoupons($order)));
        $addPayment->setPaymentType($lastPayment?->getMethod()?->getName());

        $this->addItems($addPayment);
        return $addPayment;
    }

    public function addShippingInfo(): AddShippingInfo
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        /** @var ShipmentInterface|null $shipment */
        $shipment = $order->getShipments()->first();

        $addShippingInfo = new AddShippingInfo();
        $addShippingInfo->setCoupon(implode(', ', $this->getCoupons($order)));
        $addShippingInfo->setShippingTier($shipment?->getMethod()?->getName());

        $this->addItems($addShippingInfo);
        return $addShippingInfo;
    }

    public function purchase(): Purchase
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();

        $purchase = new Purchase((string) $order->getTokenValue());

        $purchase->setCoupon(implode(', ', $this->getCoupons($order)));
        $purchase->setShipping($order->getShippingTotal()/100);
        $purchase->setTax($order->getTaxTotal()/100);

        $this->addItems($purchase);
        return $purchase;
    }

    /**
     * @param ItemsContainerInterface $event
     * @return void
     */
    private function addItems(ItemsContainerInterface $event): void
    {
        /** @var OrderInterface $orderItem */
        foreach ($this->cartContext->getCart()->getItems() as $orderItem) {
            $event->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );
        }
    }

    private function getCoupons(OrderInterface $order): array
    {
        $result = [];
        foreach ($order->getPromotions() as $promotion)
        {
            $result[] = $promotion->getName();
        }

        return $result;
    }
}
