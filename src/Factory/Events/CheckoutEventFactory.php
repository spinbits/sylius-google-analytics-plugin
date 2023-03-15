<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events;


use Doctrine\Common\Collections\Collection;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\AddAddressInfo;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\AddPaymentInfo;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\AddShippingInfo;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\BeginCheckout;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\Purchase;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\ItemsContainerInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactoryInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class CheckoutEventFactory
{
    public function __construct(
        private CartContextInterface $cartContext,
        private ItemFactoryInterface $itemFactory
    ) {
    }

    public function beginCheckout(): BeginCheckout
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();

        $beginCheckout = new BeginCheckout();
        $beginCheckout->setCoupon(implode(', ', $this->getCoupons($order)));

        $this->addItems($beginCheckout, $order->getItems());
        return $beginCheckout;
    }

    public function addAddressInfo(): AddAddressInfo
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();

        $addAddress = new AddAddressInfo();
        $addAddress->setCoupon(implode(', ', $this->getCoupons($order)));

        $this->addItems($addAddress, $order->getItems());
        return $addAddress;
    }

    public function addPaymentInfo(): AddPaymentInfo
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        $lastPayment = $order->getLastPayment();

        $addPayment = new AddPaymentInfo();
        $addPayment->setCoupon(implode(', ', $this->getCoupons($order)));
        $addPayment->setPaymentType($lastPayment?->getMethod()?->getName());

        $this->addItems($addPayment, $order->getItems());
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

        $this->addItems($addShippingInfo, $order->getItems());
        return $addShippingInfo;
    }

    public function purchase(Order $order): Purchase
    {
        $purchase = new Purchase((string) $order->getNumber());

        $purchase->setCoupon(implode(', ', $this->getCoupons($order)));
        $purchase->setShipping($order->getShippingTotal()/100);
        $purchase->setTax($order->getTaxTotal()/100);

        /** @var Collection<array-key, OrderItemInterface> $items */
        $items = $order->getItems();
        $this->addItems($purchase, $items);
        return $purchase;
    }


    /**
     * @param ItemsContainerInterface $event
     * @param Collection<array-key, OrderItemInterface> $items
     * @return void
     */
    private function addItems(ItemsContainerInterface $event, Collection $items): void
    {
        foreach ($items as $orderItem) {
            $event->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );
        }
    }

    /**
     * @param OrderInterface $order
     * @return array<array-key, string>
     */
    private function getCoupons(OrderInterface $order): array
    {
        $result = [];
        foreach ($order->getPromotions() as $promotion)
        {
            $result[] = (string) $promotion->getName();
        }

        return $result;
    }
}
