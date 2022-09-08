<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\AuthEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\CartEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\CheckoutEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\NavigationEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EventListener implements EventSubscriberInterface
{
    private AuthEventFactory $authEventFactory;
    private CartEventFactory $cartEventFactory;
    private CheckoutEventFactory $checkoutEventFactory;
    private NavigationEventFactory $navEventFactory;
    private EventsBag $eventsStorage;

    /**
     * @param AuthEventFactory $authEventFactory
     * @param CartEventFactory $cartEventFactory
     * @param CheckoutEventFactory $checkoutEventFactory
     * @param NavigationEventFactory $navEventFactory
     * @param EventsBag $eventsStorage
     */
    public function __construct(
        AuthEventFactory $authEventFactory,
        CartEventFactory $cartEventFactory,
        CheckoutEventFactory $checkoutEventFactory,
        NavigationEventFactory $navEventFactory,
        EventsBag $eventsStorage
    ) {
        $this->authEventFactory = $authEventFactory;
        $this->cartEventFactory = $cartEventFactory;
        $this->checkoutEventFactory = $checkoutEventFactory;
        $this->navEventFactory = $navEventFactory;
        $this->eventsStorage = $eventsStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.order_item.post_add' => 'addToCart',
            'sylius.order_item.post_remove' => 'removeFromCart',
            'sylius.customer.post_register' => 'signup',
            'sylius.shop_user.post_create' => 'signup',
            'security.interactive_login' => 'login',
            'sylius.product.show' => 'viewItem'
        ];
    }

    public function addToCart(ResourceControllerEvent $resourceControllerEvent): void
    {
        $orderItem = $resourceControllerEvent->getSubject();

        if (!$orderItem instanceof OrderItemInterface) {
            return;
        }

        $this->eventsStorage->addEvent(
            $this->cartEventFactory->addToCart($orderItem)
        );
    }

    public function removeFromCart(ResourceControllerEvent $resourceControllerEvent): void
    {
        $orderItem = $resourceControllerEvent->getSubject();

        if (!$orderItem instanceof OrderItemInterface) {
            return;
        }

        $this->eventsStorage->addEvent(
            $this->cartEventFactory->removeFromCart($orderItem)
        );
    }

    public function signup(GenericEvent $event): void
    {
        $this->eventsStorage->addEvent(
            $this->authEventFactory->signup()
        );
    }

    public function login(GenericEvent $event): void
    {
        $this->eventsStorage->addEvent(
            $this->authEventFactory->login()
        );
    }

    public function viewItem(ResourceControllerEvent $resourceControllerEvent): void
    {
        $product = $resourceControllerEvent->getSubject();

        if (!$product instanceof ProductInterface) {
            return;
        }

        $this->eventsStorage->addEvent(
            $this->navEventFactory->viewItem($product)
        );
    }
}
