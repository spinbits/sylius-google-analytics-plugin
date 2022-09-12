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

class RenderHeadTwigFactory
{
    private Environment $twig;
    private string $id;
    private string $additionalParams;
    private string $templateName;
    private bool $enabled;

    /**
     * @param Environment $twig
     * @param string $id
     * @param string $additionalParams
     * @param string $templateName
     * @param bool $enabled
     */
    public function __construct(
        Environment $twig,
        string $id,
        string $additionalParams,
        string $templateName,
        bool $enabled
    ) {
        $this->twig = $twig;
        $this->id = $id;
        $this->additionalParams = $additionalParams ? '&'.trim($additionalParams,'&') : '';
        $this->enabled = $enabled;
        $this->templateName = $templateName;
    }

    public function render(): string
    {
        return !$this->enabled ? '' : $this->twig->render(
            $this->templateName, [
                'id' => $this->id,
                'url_suffix' => $this->additionalParams
            ]
        );
    }
}
