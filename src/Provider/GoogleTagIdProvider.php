<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Provider;


use Sylius\Component\Channel\Context\ChannelContextInterface;

class GoogleTagIdProvider implements GoogleTagIdProviderInterface
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        /** @var array<string, string>|string[]|null $channelsIds */
        private ?array $channelsIds = null
    ) {
    }

    public function provide(): string
    {
        if (is_array($this->channelsIds)) {
            foreach ($this->channelsIds as $channelCode => $id) {
                if ($this->channelContext->getChannel()->getCode() === $channelCode) {
                    return $id;
                }
            }
        }
    }

}
