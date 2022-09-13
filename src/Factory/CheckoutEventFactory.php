<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;


use Doctrine\Common\Collections\Collection;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddAddressInfo;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddPaymentInfo;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddShippingInfo;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\BeginCheckout;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Purchase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ItemsContainerInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Model\OrderItemInterface;

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

        $this->addItems($beginCheckout, $this->cartContext->getCart()->getItems());
        return $beginCheckout;
    }

    public function addAddressInfo(): AddAddressInfo
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        /** @var PaymentInterface|null $lastPayment */
        $lastPayment = $order->getLastPayment();

        $addAddress = new AddAddressInfo();
        $addAddress->setCoupon(implode(', ', $this->getCoupons($order)));

        $this->addItems($addAddress, $this->cartContext->getCart()->getItems());
        return $addAddress;
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

        $this->addItems($addPayment, $this->cartContext->getCart()->getItems());
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

        $this->addItems($addShippingInfo, $this->cartContext->getCart()->getItems());
        return $addShippingInfo;
    }

    public function purchase(Order $order): Purchase
    {
        $purchase = new Purchase((string) $order->getNumber());

        $purchase->setCoupon(implode(', ', $this->getCoupons($order)));
        $purchase->setShipping($order->getShippingTotal()/100);
        $purchase->setTax($order->getTaxTotal()/100);

        $this->addItems($purchase, $order->getItems());
        return $purchase;
    }


    /**
     * @param ItemsContainerInterface $event
     * @param Collection|OrderItemInterface[] $items
     * @return void
     */
    private function addItems(ItemsContainerInterface $event, Collection $items): void
    {
        /** @var OrderInterface $orderItem */
        foreach ($items as $orderItem) {
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
