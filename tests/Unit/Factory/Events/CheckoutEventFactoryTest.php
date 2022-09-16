<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory\Events;

use Doctrine\Common\Collections\ArrayCollection;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\CheckoutEventFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactory;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethod;
use Sylius\Component\Core\Model\Promotion;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

class CheckoutEventFactoryTest extends TestCase
{
    /** @var CheckoutEventFactory */
    private $sut;

    /** @var CartContextInterface | MockObject */
    private CartContextInterface $cartContext;

    /** @var ItemFactory | MockObject */
    private ItemFactory $itemFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartContext = $this->createMock(CartContextInterface::class);
        $this->itemFactory = $this->createMock(ItemFactory::class);

        $this->sut = new CheckoutEventFactory(
            $this->cartContext,
            $this->itemFactory
        );
    }

    public function testBeginCheckout()
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn('Promo 1');

        $orderItem = $this->createMock(OrderItemInterface::class);

        $order = $this->createMock(OrderInterface::class);
        $order->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $order->method('getPromotions')->willReturn(new ArrayCollection([$promotion]));

        $this->cartContext->method('getCart')->willReturn($order);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem');

        $result = $this->sut->beginCheckout();

        $this->assertSame('begin_checkout', $result->getName());
        $this->assertSame('{"coupon":"Promo 1","currency":"","value":0,"items":[[]]}', (string) $result);
    }

    public function testAddAddressInfo()
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn('Promo 1');

        $orderItem = $this->createMock(OrderItemInterface::class);

        $order = $this->createMock(OrderInterface::class);
        $order->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $order->method('getPromotions')->willReturn(new ArrayCollection([$promotion]));

        $this->cartContext->method('getCart')->willReturn($order);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem')
            ->with(...[$orderItem]);

        $result = $this->sut->addAddressInfo();

        $this->assertSame('add_address_info', $result->getName());
        $this->assertSame('{"coupon":"Promo 1","currency":"","value":0,"items":[[]]}', (string) $result);
    }

    public function testAddPaymentInfo()
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn('Promo 1');

        $orderItem = $this->createMock(OrderItemInterface::class);

        $paymentMethod = $this->createMock(PaymentMethod::class);
        $paymentMethod
            ->expects($this->once())
            ->method('getName')
            ->willReturn('Paypal');

        $payment = $this->createMock(PaymentInterface::class);
        $payment
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn($paymentMethod);

        $order = $this->createMock(OrderInterface::class);
        $order->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $order->method('getPromotions')->willReturn(new ArrayCollection([$promotion]));
        $order->method('getLastPayment')->willReturn($payment);

        $this->cartContext->method('getCart')->willReturn($order);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem')
            ->with(...[$orderItem]);

        $result = $this->sut->addPaymentInfo();

        $expected = '{"coupon":"Promo 1","payment_type":"Paypal","currency":"","value":0,"items":[[]]}';
        $this->assertSame('add_payment_info', $result->getName());
        $this->assertSame($expected, (string) $result);
    }

    public function testAddShippingInfo()
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn('Promo 1');

        $orderItem = $this->createMock(OrderItemInterface::class);

        $shipmentMethod = $this->createMock(ShippingMethodInterface::class);
        $shipmentMethod
            ->expects($this->once())
            ->method('getName')
            ->willReturn('UPS');

        $shipment = $this->createMock(ShipmentInterface::class);
        $shipment
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn($shipmentMethod);

        $order = $this->createMock(OrderInterface::class);
        $order->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $order->method('getPromotions')->willReturn(new ArrayCollection([$promotion]));
        $order->method('getShipments')->willReturn(new ArrayCollection([$shipment]));

        $this->cartContext->method('getCart')->willReturn($order);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem')
            ->with(...[$orderItem]);

        $result = $this->sut->addShippingInfo();

        $expected = '{"coupon":"Promo 1","shipping_tier":"UPS","currency":"","value":0,"items":[[]]}';
        $this->assertSame('add_shipping_info', $result->getName());
        $this->assertSame($expected, (string) $result);
    }

    public function testPurchase()
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn('Promo 1');

        $orderItem = $this->createMock(OrderItemInterface::class);

        $order = $this->createMock(Order::class);
        $order->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $order->method('getNumber')->willReturn('000023');
        $order->method('getPromotions')->willReturn(new ArrayCollection([$promotion]));
        $order->method('getTaxTotal')->willReturn(323);
        $order->method('getShippingTotal')->willReturn(350);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem')
            ->with(...[$orderItem]);

        $result = $this->sut->purchase($order);

        $expected = '{"transaction_id":"000023","coupon":"Promo 1","shipping":3.5,"tax":3.23,"currency":"","value":6.73,"items":[[]]}';
        $this->assertSame('purchase', $result->getName());
        $this->assertSame($expected, (string) $result);
    }
}
