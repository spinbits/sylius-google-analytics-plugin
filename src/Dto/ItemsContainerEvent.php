<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Exception\CurrencyNotValidException;

class ItemsContainerEvent implements ItemsContainerInterface
{
    protected ?string $currency = null;
    protected ?float $value = null;
    protected array $items = [];

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param Item $item
     * @throws CurrencyNotValidException
     */
    public function addItem(Item $item): void
    {
        $this->calculate($item);
        $this->items[] = $item;
    }

    /**
     * @param Item $item
     * @throws CurrencyNotValidException
     */
    protected function calculate(Item $item)
    {
        if ($this->currency === null and count($this->items) === 0) {
            $this->currency = $item->getCurrency();
        }

        if ($item->getCurrency() != $this->currency) {
            throw new CurrencyNotValidException();
        }
        $this->currency = $item->getCurrency();

        $this->value = round($this->value + $item->getPrice() - $item->getDiscount(), 2);
    }
}
