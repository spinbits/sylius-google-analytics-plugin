<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Search;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewItem;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewItemList;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ItemsContainerInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactory;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductInterface as ProdProductInterface;

class NavigationEventFactory
{
    public function __construct(private ItemFactory $itemFactory)
    {
    }

    public function search(string $searchTerm): Search
    {
        return new Search($searchTerm);
    }

    /**
     * @param array<array-key, ProductInterface> $products
     * @param null|string $itemListId
     * @param null|string $itemListName
     * @return ViewItemList
     */
    public function viewItemList(
        array $products = [],
        ?string $itemListId = null,
        ?string $itemListName = null
    ): ViewItemList
    {
        $viewItemList = (new ViewItemList())
            ->setItemListId($itemListId)
            ->setItemListName($itemListName);
        $this->addItems($viewItemList, $products);

        return $viewItemList;
    }

    public function viewItem(ProductInterface $product): ViewItem
    {
        $viewItem = new ViewItem();
        $viewItem->addItem($this->itemFactory->fromProduct($product));

        return $viewItem;
    }

    /**
     * @param ItemsContainerInterface $event
     * @param array<array-key, ProdProductInterface>|ProductInterface[] $products
     * @return void
     */
    private function addItems(ItemsContainerInterface $event, array $products): void
    {
        foreach ($products as $product) {
            $event->addItem(
                $this->itemFactory->fromProduct($product)
            );
        }
    }
}
