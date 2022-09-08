<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Storage;


use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionFactoryWithEventsBag implements SessionFactoryInterface
{
    private SessionFactoryInterface $delegate;
    private EventsBag $eventsBag;

    public function __construct(SessionFactoryInterface $delegate, EventsBag $eventsBag)
    {
        $this->delegate = $delegate;
        $this->eventsBag = $eventsBag;
    }

    public function createSession(): SessionInterface
    {
        $session = $this->delegate->createSession();
        $session->registerBag($this->eventsBag);

        return $session;
    }
}
