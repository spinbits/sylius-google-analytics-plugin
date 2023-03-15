<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Spinbits\SyliusGoogleAnalytics4Plugin\Provider\GoogleTagIdProviderInterface;
use Twig\Environment;

class RenderHeadTwigFactory implements RenderHeadTwigFactoryInterface
{
    public function __construct(
        private GoogleTagIdProviderInterface $googleTagProvider,
        private Environment                  $twig,
        private string                       $additionalParams,
        private string                       $templateName,
        private bool                         $enabled,
    ) {
        $this->additionalParams = $additionalParams ? '&'.trim($additionalParams,'&') : '';
    }

    public function render(): string
    {
        return !$this->enabled ? '' : $this->twig->render(
            $this->templateName, [
                'id' => $this->googleTagProvider->provide(),
                'url_suffix' => $this->additionalParams
            ]
        );
    }
}
