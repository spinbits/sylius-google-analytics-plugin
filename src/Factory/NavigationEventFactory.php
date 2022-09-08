<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;


use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Search;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewItem;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewItemList;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerInterface;
use Sylius\Component\Core\Model\ProductInterface;

class NavigationEventFactory
{
    private ItemFactory $itemFactory;

    /**
     * @param ItemFactory $itemFactory
     */
    public function __construct(ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }


    public function search(string $searchTerm): Search
    {
        return new Search($searchTerm);
    }

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
        return (new ViewItem())
            ->addItem($this->itemFactory->fromProduct($product));
    }

    /**
     * @param ItemsContainerInterface $event
     * @param array|ProductInterface[] $products
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
