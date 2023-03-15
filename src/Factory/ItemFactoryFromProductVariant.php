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
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;

class ItemFactoryFromProductVariant implements ItemFactoryFromProductVariantInterface
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        private CurrencyContextInterface $currencyContext,
    ) {
    }

    public function create(ProductVariantInterface $variant): Item
    {
        /** @var ProductVariant $variant */
        /** @var Channel $channel */
        $channel = $this->channelContext->getChannel();
        /** @var ChannelPricingInterface|null $pricing */
        /** @var ProductVariant $variant */
        $pricing = $variant->getChannelPricingForChannel($channel);
        $price = $pricing?->getPrice() ?? $pricing?->getOriginalPrice() ?? 0;
        /** @var Product|null $product */
        $product = $variant->getProduct();
        /** @var Taxon|null $mainTaxon */
        $mainTaxon = $product?->getMainTaxon();

        return new Item(
            (string) $variant->getId(),
            (string) $variant->getCode(),
            round($price/100, 2),
            $this->currencyContext->getCurrencyCode(),
            0,
            1,
            null,
            null,
            null,
            null,
            $this->getCategories($product),
            (string) $mainTaxon?->getId(),
            (string) $mainTaxon?->getName(),
            $variant->getName(),
            $channel->getName(),
        );
    }

    private function getCategories(?ProductInterface $product): array
    {
        /** @var Product|null $product */
        if (null === $product) {
            return [];
        }
        $taxons = [];
        /** @var Taxon $taxon */
        foreach ($product->getTaxons() as $taxon) {
            $taxons[] = (string) $taxon->getName();
        }

        return $taxons;
    }
}
