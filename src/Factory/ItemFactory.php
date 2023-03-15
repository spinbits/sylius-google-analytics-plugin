<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Spinbits\GoogleAnalytics4EventsDtoS\Item\Item;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;

class ItemFactory
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        private CurrencyContextInterface $currencyContext,
        private ProductVariantResolverInterface $productVariantResolver,
        private ItemFactoryFromProductVariantInterface $itemFactoryFromVariant
    ) {
    }

    public function fromProductVariant(ProductVariantInterface $variant): Item
    {
        return $this->itemFactoryFromVariant->create($variant);
    }

    public function fromProduct(ProductInterface $product): Item
    {
        if ($product->getEnabledVariants()->isEmpty()) {
            return $this->returnMissingItem('variant missing for product '. (string) $product->getId());
        }

        /** @var ProductVariantInterface $variant */
        $variant = $this->productVariantResolver->getVariant($product);

        return $this->fromProductVariant($variant);
    }

    public function fromOrderItem(OrderItemInterface $orderItem): Item
    {
        /** @var OrderItem $orderItem */
        $variant = $orderItem->getVariant();
        if (null === $variant) {
            return $this->returnMissingItem('variant missing for orderItem: '. (string) $orderItem->getId());
        }
        /** @var ProductVariantInterface $variant */
        $item = $this->fromProductVariant($variant);
        $price = ($orderItem->getUnitPrice() > 0) ? $orderItem->getUnitPrice()/100 : (float) $item->getPrice()/100;

        return $item
            ->setQuantity($orderItem->getQuantity())
            ->setPrice((float) $price)
            ->setDiscount(($orderItem->getUnitPrice() - $orderItem->getFullDiscountedUnitPrice())/100)
            ->setCoupon(implode(', ', $this->getCoupons($orderItem)))
            ;
    }

    /**
     * @param OrderItemInterface $orderItem
     * @return array<array-key, string>
     */
    private function getCoupons(OrderItemInterface $orderItem): array
    {
        /** @var Order|null $order */
        $order = $orderItem->getOrder();
        if (null === $order) {
            return [];
        }

        $result = [];
        foreach ($order->getPromotions() as $promotion)
        {
            $result[] = (string) $promotion->getName();
        }

        return $result;
    }

    private function returnMissingItem(string $message): Item
    {
        //we can not throw exception in this process so we return empty Item with notification
        return new Item(
            '0',
            $message,
            0,
            $this->currencyContext->getCurrencyCode()
        );
    }
}
