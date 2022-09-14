<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Storage;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\EventInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class EventsBag extends FlashBag
{
    private const FLASH_BAG_NAME = 'spinbits_ga4_events';

    public function __construct(string $storageKey = self::FLASH_BAG_NAME)
    {
        parent::__construct($storageKey);
        $this->setName($storageKey);
    }

    public function setEvent(EventInterface $event): void
    {
        $this->set($event->getName(), [$event]);
    }

    public function getEvents(): array
    {
        return $this->all();
    }
}
