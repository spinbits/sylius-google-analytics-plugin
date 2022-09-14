<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventsBagSessionFactory implements SessionFactoryInterface
{
    public function __construct(private SessionFactoryInterface $delegate, private EventsBag $eventsBag)
    {
    }

    public function createSession(): SessionInterface
    {
        $session = $this->delegate->createSession();
        $session->registerBag($this->eventsBag);

        return $session;
    }
}
