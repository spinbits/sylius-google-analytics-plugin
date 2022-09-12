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
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;

class ViewItemList extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $item_list_id = null;
    private ?string $item_list_name = null;

    public function getName(): string
    {
        return 'view_item_list';
    }

    /**
     * @param null|string $item_list_id
     * @return ViewItemList
     */
    public function setItemListId(?string $item_list_id)
    {
        $this->item_list_id = $item_list_id;
        return $this;
    }

    /**
     * @param null|string $item_list_name
     * @return ViewItemList
     */
    public function setItemListName(?string $item_list_name)
    {
        $this->item_list_name = $item_list_name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function calculate(ItemInterface $item): void{}
}
