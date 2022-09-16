<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Promotion;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;

class ItemFactoryTest extends TestCase
{
    /** @var ItemFactory */
    private $sut;

    /** @var ChannelContextInterface|MockObject */
    private ChannelContextInterface $channelContext;

    /** @var CurrencyContextInterface|MockObject  */
    private CurrencyContextInterface $currencyContext;

    /** @var ProductVariantResolverInterface|MockObject  */
    private ProductVariantResolverInterface $productVariantResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channelContext = $this->createMock(ChannelContextInterface::class);
        $this->currencyContext = $this->createMock(CurrencyContextInterface::class);
        $this->productVariantResolver = $this->createMock(ProductVariantResolverInterface::class);

        $channel = $this->createMock(Channel::class);
        $channel->method('getName')->willReturn('Example Channel');
        $this->channelContext->method('getChannel')->willReturn($channel);

        $this->currencyContext->method('getCurrencyCode')->willReturn('USD');

        $this->sut = new ItemFactory(
            $this->channelContext,
            $this->currencyContext,
            $this->productVariantResolver
        );
    }

    public function testCreateFromProductVariant()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 1.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductVariantMissingPricing()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = null;
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 0.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductVariantMissingPrice()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(null, 150);;
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 1.50,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductVariantMissingPriceAndOriginalPrice()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(null, null);;
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 0.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductVariantMissingMainTaxon()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = null;
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '',
            'item_list_name' => '',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 1.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductVariantMissingMainTaxonIdAndName()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $mainTaxon = $this->taxonProvider(null, null);
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $result = $this->sut->fromProductVariant($variant);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '',
            'item_list_name' => '',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 1.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProduct()
    {
        $taxon = $this->taxonProvider(43, 'Category else');

        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $this->productVariantResolver->method('getVariant')->willReturn($variant);

        $result = $this->sut->fromProduct($product);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'currency' => 'USD',
            'discount' => 0.0,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 1.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromProductMissingVariant()
    {
        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection(), false);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $this->productVariantResolver->method('getVariant')->willReturn($variant);

        $result = $this->sut->fromProduct($product);
        $expected = [
            'item_id' => '0',
            'item_name' => 'variant missing for product 1',
            'currency' => 'USD',
            'discount' => 0.0,
            'price' => 0.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromOrderItem()
    {
        $taxon = $this->taxonProvider(43, 'Category else');
        $promotion = $this->promotionProvider('Promotion some');

        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, new ArrayCollection([$taxon]), true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = $this->productVariantProvider(1, 'ProdVar1', $product, $pricing);

        $order = $this->orderProvider(new ArrayCollection([$promotion]));
        $orderItem = $this->orderItemProvider(832, $variant, 450, 2, 100, $order);

        $result = $this->sut->fromOrderItem($orderItem);
        $expected = [
            'item_id' => '1',
            'item_name' => '',
            'coupon' => 'Promotion some',
            'currency' => 'USD',
            'discount' => 3.5,
            'item_category' => 'Category else',
            'item_list_id' => '23',
            'item_list_name' => 'Category Main',
            'item_variant' => 'ProdVar1',
            'location_id' => 'Example Channel',
            'price' => 4.5,
            'quantity' => 2,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    public function testCreateFromOrderItemMissingVariant()
    {
        $iterator = $this->createMock(\Iterator::class);
        $collection = $this->createMock(Collection::class);
        $collection->method('getIterator')->willReturn($iterator);

        $mainTaxon = $this->taxonProvider(23, 'Category Main');
        $product = $this->productProvider(1, $mainTaxon, $collection, true);
        $pricing = $this->channelPricingProvider(100, 150);
        $variant = null;

        $order = $this->orderProvider($collection);
        $orderItem = $this->orderItemProvider(832, $variant, 450, 2, 100, $order);

        $result = $this->sut->fromOrderItem($orderItem);
        $expected = [
            'item_id' => '0',
            'item_name' => 'variant missing for orderItem: 832',
            'currency' => 'USD',
            'discount' => 0.0,
            'price' => 0.0,
            'quantity' => 1,
        ];

        $this->assertSame($expected, $result->jsonSerialize());
    }

    private function orderProvider(Collection $promotions): Order
    {
        $order = $this->createMock(Order::class);

        $order->method('getPromotions')->willReturn($promotions);

        return $order;
    }

    private function orderItemProvider(int $id, ?ProductVariant $variant, int $unitPrice, int $qty, int $discountedUnitPrice, ?Order $order = null): OrderItem
    {
        $orderItem = $this->createMock(OrderItem::class);

        $orderItem->method('getId')->willReturn($id);
        $orderItem->method('getVariant')->willReturn($variant);
        $orderItem->method('getUnitPrice')->willReturn($unitPrice);
        $orderItem->method('getQuantity')->willReturn($qty);
        $orderItem->method('getFullDiscountedUnitPrice')->willReturn($discountedUnitPrice);
        $orderItem->method('getOrder')->willReturn($order);

        return $orderItem;
    }

    /**
     * @return MockObject|ProductVariant
     */
    private function productVariantProvider(?int $id, ?string $name, ?MockObject $product, ?MockObject $pricing): ProductVariant
    {
        $variant = $this->createMock(ProductVariant::class);

        $variant->method('getChannelPricingForChannel')->willReturn($pricing);
        $variant->method('getId')->willReturn($id);
        $variant->method('getName')->willReturn($name);
        $variant->method('getProduct')->willReturn($product);

        return $variant;
    }

    /**
     * @return MockObject|Product
     */
    private function productProvider(int $id, ?MockObject $taxon, Collection $taxons, bool $hasEnabledVariants): Product
    {
        $product = $this->createMock(Product::class);

        $enabledVariants = $this->createMock(Collection::class);
        $enabledVariants->method('isEmpty')->willReturn(!$hasEnabledVariants);

        $product->method('getId')->willReturn($id);
        $product->method('getMainTaxon')->willReturn($taxon);
        $product->method('getTaxons')->willReturn($taxons);
        $product->method('getEnabledVariants')->willReturn($enabledVariants);

        return $product;
    }

    private function channelPricingProvider(?int $price, ?int $originalPrice): ChannelPricingInterface
    {
        $channelPricing = $this->createMock(ChannelPricingInterface::class);

        $channelPricing->method('getPrice')->willReturn($price);
        $channelPricing->method('getOriginalPrice')->willReturn($originalPrice);

        return $channelPricing;
    }

    private function taxonProvider(?int $id, ?string $name): Taxon
    {
        $taxon = $this->createMock(Taxon::class);
        $taxon->method('getName')->willReturn($name);
        $taxon->method('getId')->willReturn($id);

        return $taxon;
    }

    private function promotionProvider(string $name): Promotion
    {
        $promotion = $this->createMock(Promotion::class);
        $promotion->method('getName')->willReturn($name);

        return $promotion;
    }
}
