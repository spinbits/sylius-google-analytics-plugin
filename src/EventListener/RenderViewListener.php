<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\RenderHeadTwigFactory;

class RenderViewListener
{
    public function __construct(private RenderHeadTwigFactory $renderTwig)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$this->isAllowed($event)) {
            return;
        }

        if ($event->getResponse() instanceof BinaryFileResponse) {
            return;
        }

        if ($event->getResponse() instanceof StreamedResponse) {
            return;
        }

        $event->getResponse()->setContent(
            preg_replace(
                '/<head\b[^>]*>/',
                "$0" . $this->renderTwig->render(),
                (string) $event->getResponse()->getContent(),
                1
            )
        );
    }

    private function isAllowed(ResponseEvent $event): bool
    {
        return in_array($event->getResponse()->headers->get('content-type'), ['text/html', null])
            && $event->getResponse()->headers->get('location') === null
            && $event->isMainRequest();
    }
}
