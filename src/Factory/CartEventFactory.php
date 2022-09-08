<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;


use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\AddToCart;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\RemoveFromCart;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewCart;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class CartEventFactory
{
    private ItemFactory $itemFactory;
    private CartContextInterface $cartContext;

    /**
     * @param ItemFactory $itemFactory
     * @param CartContextInterface $cartContext
     */
    public function __construct(ItemFactory $itemFactory, CartContextInterface $cartContext)
    {
        $this->itemFactory = $itemFactory;
        $this->cartContext = $cartContext;
    }

    public function addToCart(OrderItemInterface $orderItem): AddToCart
    {
        return (new AddToCart())
            ->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );
    }

    public function viewCart(): ViewCart
    {
        $viewCart = new ViewCart();
        foreach ($this->cartContext->getCart()->getItems() as $orderItem) {
            $viewCart->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );
        }

        return $viewCart;
    }

    public function removeFromCart(OrderItemInterface $orderItem): RemoveFromCart
    {
        return (new RemoveFromCart())
            ->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );
    }
}
