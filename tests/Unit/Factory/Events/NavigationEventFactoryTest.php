<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory\Events;

use Spinbits\GoogleAnalytics4EventsDtoS\Item\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\NavigationEventFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\ItemFactoryInterface;
use Sylius\Component\Core\Model\Product;

class NavigationEventFactoryTest extends TestCase
{
    /** @var NavigationEventFactory */
    private $sut;

    /** @var ItemFactoryInterface | MockObject  */
    private ItemFactoryInterface $itemFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemFactory = $this->createMock(ItemFactoryInterface::class);

        $this->sut = new NavigationEventFactory($this->itemFactory);
    }

    public function testSearch()
    {
        $result = $this->sut->search('term');

        $this->assertSame('search', $result->getName());
        $this->assertSame('{"search_term":"term"}', (string) $result);
    }

    public function testViewItemList()
    {
        $product = $this->createMock(Product::class);

        $item = $this->createMock(Item::class);
        $this->itemFactory
            ->expects($this->once())
            ->method('fromProduct')
            ->with(...[$product])
            ->willReturn($item);

        $result = $this->sut->viewItemList([$product], 'some id', 'some name');
        $expected = ['item_list_id'=>'some id','item_list_name'=>'some name','items'=>[$item]];
        $this->assertSame('view_item_list', $result->getName());
        $this->assertEqualsCanonicalizing($expected, $result->jsonSerialize());
    }

    public function testViewItem()
    {
        $product = $this->createMock(Product::class);

        $this->itemFactory
            ->expects($this->once())
            ->method('fromProduct')
            ->with(...[$product]);

        $result = $this->sut->viewItem($product);

        $expected = '{"currency":"","value":0,"items":[[]]}';
        $this->assertSame('view_item', $result->getName());
        $this->assertSame($expected, (string) $result);
    }
}
