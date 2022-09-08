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
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class SelectItem extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $item_list_id = null;
    private ?string $item_list_name = null;

    public function getName(): string
    {
        return 'select_item';
    }

    /**
     * @param string|null $item_list_id
     * @return SelectItem
     */
    public function setItemListId(?string $item_list_id): SelectItem
    {
        $this->item_list_id = $item_list_id;
        return $this;
    }

    /**
     * @param string|null $item_list_name
     * @return SelectItem
     */
    public function setItemListName(?string $item_list_name): SelectItem
    {
        $this->item_list_name = $item_list_name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function calculate(Item $item): void{}
}
