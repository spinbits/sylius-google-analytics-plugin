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

class LevelUp implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?float $level = null;
    private ?string $character = null;

    public function getName(): string
    {
        return 'level_up';
    }

    /**
     * @param float|null $level
     * @return LevelUp
     */
    public function setLevel(?float $level): LevelUp
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param string|null $character
     * @return LevelUp
     */
    public function setCharacter(?string $character): LevelUp
    {
        $this->character = $character;
        return $this;
    }
}
