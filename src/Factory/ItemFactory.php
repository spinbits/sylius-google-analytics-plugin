<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\Item;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;

class ItemFactory
{
    private ChannelContextInterface $channelContext;
    private CurrencyContextInterface $currencyContext;
    private ProductVariantResolverInterface $productVariantResolver;

    /**
     * @param ChannelContextInterface $channelContext
     * @param CurrencyContextInterface $currencyContext
     * @param ProductVariantResolverInterface $productVariantResolver
     */
    public function __construct(
        ChannelContextInterface $channelContext,
        CurrencyContextInterface $currencyContext,
        ProductVariantResolverInterface $productVariantResolver
    ) {
        $this->channelContext = $channelContext;
        $this->currencyContext = $currencyContext;
        $this->productVariantResolver = $productVariantResolver;
    }


    public function fromProductVariant(ProductVariantInterface $variant): Item
    {
        /** @var Channel $channel */
        $channel = $this->channelContext->getChannel();
        /** @var ChannelPricingInterface $pricing */
        $pricing = $variant->getChannelPricingForChannel($channel);
        $price = (null !== $pricing) ? $pricing->getPrice() ?? $pricing->getOriginalPrice() ?? 0 : 0;
        $price /= 100;
        return new Item(
            (string) $variant->getId(),
            (string) $variant->getCode(),
            $price,
            $this->currencyContext->getCurrencyCode(),
            0,
            1,
            null,
            null,
            null,
            null,
            $this->getCategories($variant->getProduct()),
            (string) $variant->getProduct()->getMainTaxon()->getId(),
            $variant->getProduct()->getMainTaxon()->getName(),
            $variant->getName(),
            $channel->getName(),
        );
    }

    public function fromProduct(ProductInterface $product): Item
    {
        return $this->fromProductVariant(
            $this->productVariantResolver->getVariant($product)
        );
    }

    public function fromOrderItem(OrderItemInterface $orderItem): Item
    {
        $item = $this->fromProductVariant($orderItem->getVariant());
        $price = ($orderItem->getUnitPrice() > 0) ? $orderItem->getUnitPrice()/100 : $item->getPrice()/100;
        return $item
            ->setQuantity($orderItem->getQuantity())
            ->setPrice($price)
            ->setDiscount(($orderItem->getUnitPrice() - $orderItem->getFullDiscountedUnitPrice())/100)
            ->setCoupon(implode(', ', $this->getCoupons($orderItem)))
            ;
    }

    private function getCategories(ProductInterface $product): array
    {
        $taxons = [];
        foreach ($product->getTaxons() as $taxon) {
            $taxons[] = $taxon->getName();
        }

        return $taxons;
    }

    private function getCoupons(OrderItemInterface $orderItem): array
    {
        $order = $orderItem->getOrder();
        if (null === $order) {
            return [];
        }

        $result = [];
        foreach ($order->getPromotions() as $promotion)
        {
            $result[] = $promotion->getName();
        }

        return $result;
    }
}
