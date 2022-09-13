<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Exception\CurrencyMismatchException;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\ItemInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class ItemsContainerEvent implements \JsonSerializable, ItemsContainerInterface
{
    use JsonSerializeTrait;

    protected ?string $currency = null;
    protected ?float $value = null;
    protected array $items = [];

    /**
     * @param ItemInterface $item
     * @return self
     * @throws CurrencyMismatchException
     */
    public function addItem(ItemInterface $item): self
    {
        $this->calculate($item);
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param ItemInterface $item
     * @return void
     * @throws CurrencyMismatchException
     */
    protected function calculate(ItemInterface $item): void
    {
        if ($this->currency === null and count($this->items) === 0) {
            $this->currency = $item->getCurrency();
        }

        if ($item->getCurrency() != $this->currency) {
            throw new CurrencyMismatchException();
        }

        $this->value = round((float) $this->value + $item->getValue(), 2);
    }
}
