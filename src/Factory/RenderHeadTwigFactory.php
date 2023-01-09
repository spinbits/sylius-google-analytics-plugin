<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Twig\Environment;

class RenderHeadTwigFactory
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        private Environment $twig,
        private string $id,
        private string $additionalParams,
        private string $templateName,
        private bool $enabled,
        private ?array $channelsIds = []
    ) {
        $this->additionalParams = $additionalParams ? '&'.trim($additionalParams,'&') : '';
    }

    public function render(): string
    {
        return !$this->enabled ? '' : $this->twig->render(
            $this->templateName, [
                'id' => $this->resolveGtagId($this->id, $this->channelsIds),
                'url_suffix' => $this->additionalParams
            ]
        );
    }

    private function resolveGtagId(string $defaultId, ?array $channelsIds): string
    {
        if (is_array($channelsIds)) {
            foreach ($channelsIds as $channelCode => $id) {
                if ($this->channelContext->getChannel()->getCode() === $channelCode) {
                    return (string) $id;
                }
            }
        }

        return $defaultId;
    }
}
