<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Twig;

use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GoogleAnalytics4Extension extends AbstractExtension
{
    private const NAME = 'google_analytics_4';
    private EventsBag $storage;

    /**
     * @param EventsBag $storage
     */
    public function __construct(EventsBag $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(self::NAME, [$this, 'render'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $template = '';
        $events = $this->storage->getEvents();
        foreach ($events as $name => $content) {
            foreach($content as $c) {
                $template .= sprintf('gtag("event", "%s", %s);'. PHP_EOL, $name, $c);
            }
        }
        return $template. sprintf('console.log(%s);', json_encode($events));
    }
}
