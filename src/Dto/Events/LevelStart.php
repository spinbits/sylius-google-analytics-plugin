<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class LevelStart implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $level_name = null;

    public function getName(): string
    {
        return 'level_start';
    }

    /**
     * @param string|null $level_name
     * @return LevelStart
     */
    public function setLevelName(?string $level_name): LevelStart
    {
        $this->level_name = $level_name;
        return $this;
    }
}
