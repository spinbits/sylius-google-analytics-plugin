<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\RenderHeadTwigFactory;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RenderViewListener
{
    private RenderHeadTwigFactory $renderTwig;

    /**
     * @param RenderHeadTwigFactory $renderTwig
     */
    public function __construct(RenderHeadTwigFactory $renderTwig)
    {
        $this->renderTwig = $renderTwig;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$this->isAllowed($event)) {
            return;
        }

        $event->getResponse()->setContent(
            preg_replace(
                '/<head\b[^>]*>/',
                "$0" . $this->renderTwig->render(),
                $event->getResponse()->getContent(),
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
