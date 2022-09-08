<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\EventInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class EarnVirtualCurrency implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $virtual_currency_name = null;
    private ?float $value = null;

    public function getName(): string
    {
        return 'earn_virtual_currency';
    }

    /**
     * @param string|null $virtual_currency_name
     * @return EarnVirtualCurrency
     */
    public function setVirtualCurrencyName(?string $virtual_currency_name): EarnVirtualCurrency
    {
        $this->virtual_currency_name = $virtual_currency_name;
        return $this;
    }

    /**
     * @param float|null $value
     * @return EarnVirtualCurrency
     */
    public function setValue(?float $value): EarnVirtualCurrency
    {
        $this->value = $value;
        return $this;
    }
}
