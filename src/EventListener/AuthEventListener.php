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
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthEventListener implements EventSubscriberInterface
{
    private AuthEventFactory $authEventFactory;
    private EventsBag $eventsStorage;

    /**
     * @param AuthEventFactory $authEventFactory
     * @param EventsBag $eventsStorage
     */
    public function __construct(
        AuthEventFactory $authEventFactory,
        EventsBag $eventsStorage
    ) {
        $this->authEventFactory = $authEventFactory;
        $this->eventsStorage = $eventsStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.user.security.implicit_login' => 'login',
            'security.interactive_login' => 'loginInteracive',
            'sylius.customer.post_register' => 'signup',
            'sylius.shop_user.post_create' => 'signup',
        ];
    }

    public function signup(GenericEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->authEventFactory->signup()
        );
    }

    public function login(GenericEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->authEventFactory->login()
        );
    }

    public function loginInteracive(InteractiveLoginEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->authEventFactory->login()
        );
    }
}
