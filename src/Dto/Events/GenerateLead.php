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

class GenerateLead implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private string $currency;
    private float $value;

    /**
     * @param string $currency
     * @param float $value
     */
    public function __construct(string $currency = 'USD', float $value = 0)
    {
        $this->currency = $currency;
        $this->value = $value;
    }

    public function getName(): string
    {
        return 'generate_lead';
    }
}
