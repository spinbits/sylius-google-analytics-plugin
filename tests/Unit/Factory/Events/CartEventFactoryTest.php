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
use Spinbits\GoogleAnalytics4EventsDtoS\Item\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\CartEventFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class CartEventFactoryTest extends TestCase
{
    /** @var CartEventFactory */
    private $sut;

    /** @var ItemFactoryInterface|MockObject  */
    private ItemFactoryInterface $itemFactory;

    /** @var CartContextInterface|MockObject */
    private CartContextInterface $cartContext;

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemFactory = $this->createMock(ItemFactoryInterface::class);
        $this->cartContext = $this->createMock(CartContextInterface::class);

        $item = $this->createMock(Item::class);
        $this->itemFactory
            ->expects($this->once())
            ->method('fromOrderItem')
            ->willReturn($item);

        $orderItem = $this->createMock(OrderItemInterface::class);

        $cart = $this->createMock(OrderInterface::class);
        $cart->method('getItems')->willReturn(new ArrayCollection([$orderItem]));
        $this->cartContext->method('getCart')->willReturn($cart);

        $this->sut = new CartEventFactory(
            $this->itemFactory,
            $this->cartContext
        );
    }

    /** @test */
    public function testViewCart(): void
    {
        $result = $this->sut->viewCart();

        $this->assertSame('view_cart', $result->getName());
        $this->assertSame('{"currency":"","value":0,"items":[[]]}', (string) $result);
    }

    /** @test */
    public function testAddToCart(): void
    {
        $orderItem = $this->createMock(OrderItemInterface::class);
        $result = $this->sut->addToCart($orderItem);

        $this->assertSame('add_to_cart', $result->getName());
        $this->assertSame('{"currency":"","value":0,"items":[[]]}', (string) $result);
    }

    /** @test */
    public function testRemoveFromCart(): void
    {
        $orderItem = $this->createMock(OrderItemInterface::class);
        $result = $this->sut->removeFromCart($orderItem);

        $this->assertSame('remove_from_cart', $result->getName());
        $this->assertSame('{"currency":"","value":0,"items":[[]]}', (string) $result);
    }


}
