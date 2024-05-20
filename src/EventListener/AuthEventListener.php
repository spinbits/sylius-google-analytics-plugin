<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Sylius\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\GenericEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\AuthEventFactory;

class AuthEventListener implements EventSubscriberInterface
{
    public function __construct(
        private AuthEventFactory $authEventFactory,
        private EventsBag $eventsStorage
    ) {
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

    public function login(UserEvent $event): void
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
