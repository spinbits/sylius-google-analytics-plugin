<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\CheckoutEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class CheckoutEventListener implements EventSubscriberInterface
{
    private CheckoutEventFactory $checkoutEventFactory;
    private EventsBag $eventsStorage;

    /**
     * @param CheckoutEventFactory $checkoutEventFactory
     * @param EventsBag $eventsStorage
     */
    public function __construct(
        CheckoutEventFactory $checkoutEventFactory,
        EventsBag $eventsStorage
    ) {
        $this->checkoutEventFactory = $checkoutEventFactory;
        $this->eventsStorage = $eventsStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller_arguments' => 'onKernelRequest',//beginCheckout
            'sylius.order.post_address' => 'addAddressInfo',
            'sylius.order.post_payment' => 'addPaymentInfo',
            'sylius.order.post_select_shipping' => 'addShippingInfo',
            'sylius.order.post_create' => 'purchase',
            'sylius.order.post_admin_create' => 'purchase',
            'sylius.order.post_complete' => 'purchase',
        ];
    }

    public function onKernelRequest(ControllerArgumentsEvent $event): void
    {
        /*
         * @psalm-suppress MixedArgument
         */
        $routeName = strval($event->getRequest()->attributes->get('_route'));

        if (!$event->isMainRequest()
            || $event->getRequest()->getMethod() != 'GET'
            || !\is_array($event->getController())
            || 'sylius_shop_checkout_address' != $routeName
        ) {
            return;
        }

        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->beginCheckout()
        );
    }

    public function addAddressInfo(GenericEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->addAddressInfo()
        );
    }

    public function addPaymentInfo(GenericEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->addPaymentInfo()
        );
    }

    public function addShippingInfo(GenericEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->addShippingInfo()
        );
    }

    public function purchase(ResourceControllerEvent $resourceControllerEvent): void
    {
        /** @var Order $order */
        $order = $resourceControllerEvent->getSubject();

        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->purchase($order)
        );
    }
}
