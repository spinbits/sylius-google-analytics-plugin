<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Twig\Environment;
use Sylius\Component\Channel\Context\ChannelContextInterface;

class RenderHeadTwigFactory
{
    /** @var ChannelContextInterface */
    private $channelContext;


    public function __construct(
        ChannelContextInterface $channelContext,
        private Environment $twig,
        private string $additionalParams,
        private string $templateName,
        private bool $enabled
    ) {
        $this->channelContext = $channelContext;
        $this->additionalParams = $additionalParams ? '&'.trim($additionalParams,'&') : '';
    }

    public function render(): string
    {
        return !$this->enabled ? '' : $this->twig->render(
            $this->templateName, [
                'id' => $this->channelContext->getChannel()->getGoogle(),
                'url_suffix' => $this->additionalParams
            ]
        );
    }
}
