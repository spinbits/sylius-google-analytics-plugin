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

class SpendVirtualCurrency implements \JsonSerializable
{
    use JsonSerializeTrait;

    private string $virtual_currency_name;
    private float $value;
    private ?string $item_name = null;

    /**
     * @param string $virtual_currency_name
     * @param float $value
     */
    public function __construct(string $virtual_currency_name, float $value)
    {
        $this->virtual_currency_name = $virtual_currency_name;
        $this->value = $value;
    }


    /**
     * @param string $item_name
     * @return SpendVirtualCurrency
     */
    public function setItemName(string $item_name): SpendVirtualCurrency
    {
        $this->item_name = $item_name;
        return $this;
    }


}
