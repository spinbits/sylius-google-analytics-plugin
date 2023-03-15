<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events;

use Spinbits\GoogleAnalytics4EventsDtoS\Events\AddToCart;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\RemoveFromCart;
use Spinbits\GoogleAnalytics4EventsDtoS\Events\ViewCart;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactoryInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class CartEventFactory
{
    public function __construct(
        private ItemFactoryInterface $itemFactory,
        private CartContextInterface $cartContext
    ) {
    }

    public function addToCart(OrderItemInterface $orderItem): AddToCart
    {
        $addToCart = new AddToCart();
        $addToCart->addItem(
                $this->itemFactory->fromOrderItem($orderItem)
            );

        return $addToCart;
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
        $removeFromCart = new RemoveFromCart();
        $removeFromCart->addItem(
            $this->itemFactory->fromOrderItem($orderItem)
        );

        return $removeFromCart;
    }
}
