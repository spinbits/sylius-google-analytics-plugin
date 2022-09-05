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

class PostScore implements \JsonSerializable
{
    use JsonSerializeTrait;

    private float $score;
    private ?float $level = null;
    private ?string $character = null;

    /**
     * @param float $score
     */
    public function __construct(float $score)
    {
        $this->score = $score;
    }

    public function getName(): string
    {
        return 'post_score';
    }

    /**
     * @param float|null $level
     * @return PostScore
     */
    public function setLevel(?float $level): PostScore
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param string|null $character
     * @return PostScore
     */
    public function setCharacter(?string $character): PostScore
    {
        $this->character = $character;
        return $this;
    }
}
