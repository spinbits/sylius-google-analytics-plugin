<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\CartEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class CartEventListener implements EventSubscriberInterface
{
    public function __construct(
        private CartEventFactory $cartEventFactory,
        private EventsBag $eventsStorage
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.order_item.post_add' => 'addToCart',
            'kernel.controller_arguments' => 'onKernelRequest',//viewCart
            'sylius.order_item.post_remove' => 'removeFromCart',
        ];
    }

    public function addToCart(ResourceControllerEvent $resourceControllerEvent): void
    {
        $orderItem = $resourceControllerEvent->getSubject();

        if (!$orderItem instanceof OrderItemInterface) {
            return;
        }

        $this->eventsStorage->setEvent(
            $this->cartEventFactory->addToCart($orderItem)
        );
    }

    public function onKernelRequest(ControllerArgumentsEvent $event): void
    {
        /**
         * @psalm-suppress MixedArgument
         */
        $routeName = strval($event->getRequest()->attributes->get('_route'));

        if (!$event->isMainRequest()
            || !\is_array($event->getController())
            || 'sylius_shop_cart_summary' != $routeName
        ) {
            return;
        }

        $this->eventsStorage->setEvent(
            $this->cartEventFactory->viewCart()
        );
    }

    public function removeFromCart(ResourceControllerEvent $resourceControllerEvent): void
    {
        $orderItem = $resourceControllerEvent->getSubject();

        if (!$orderItem instanceof OrderItemInterface) {
            return;
        }

        $this->eventsStorage->setEvent(
            $this->cartEventFactory->removeFromCart($orderItem)
        );
    }
}
