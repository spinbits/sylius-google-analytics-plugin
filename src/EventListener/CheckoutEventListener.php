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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
            'sylius.order.post_address' => 'beginCheckout',
            'sylius.order.post_payment' => 'addPaymentInfo',
            'sylius.order.post_select_shipping' => 'addShippingInfo',
            'sylius.order.post_complete' => 'purchase',
        ];
    }

    public function beginCheckout(ResourceControllerEvent $resourceControllerEvent): void
    {

        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->beginCheckout()
        );
    }

    public function addPaymentInfo(ResourceControllerEvent $resourceControllerEvent): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->addPaymentInfo()
        );
    }

    public function addShippingInfo(ResourceControllerEvent $resourceControllerEvent): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->addShippingInfo()
        );
    }

    public function purchase(ResourceControllerEvent $resourceControllerEvent): void
    {
        $this->eventsStorage->setEvent(
            $this->checkoutEventFactory->purchase()
        );
    }
}
