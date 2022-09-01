<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;


use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Resolver\EventResolver;
use Xynnn\GoogleTagManagerBundle\Service\GoogleTagManagerInterface;

class RequestListener
{
    private EventResolver $eventResolver;
    private GoogleTagManagerInterface $googleTagManager;

    /**
     * @param EventResolver $eventResolver
     * @param GoogleTagManagerInterface $googleTagManager
     */
    public function __construct(EventResolver $eventResolver, GoogleTagManagerInterface $googleTagManager)
    {
        $this->eventResolver = $eventResolver;
        $this->googleTagManager = $googleTagManager;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (!$event->isMainRequest()
            || !\is_array($controller)
        ) {
            return;
        }

        $this->googleTagManager->addPush(
            ['event', $this->eventResolver->resolve($event->getRequest())]
        );
    }
}
