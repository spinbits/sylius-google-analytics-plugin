<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewCart;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemInterface;

class ViewCartTest extends TestCase
{
    /** @var ViewCart */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new ViewCart();
    }

    public function testGetName()
    {
        $this->assertSame('view_cart', $this->sut->getName());
    }

    public function testSerializeMockItem()
    {
        $item=$this->createMock(ItemInterface::class);

        $item->expects($this->any())
            ->method('getCurrency')
            ->willReturn('USD');

        $item->expects($this->any())
            ->method('getPrice')
            ->willReturn(1.23);

        $item->expects($this->any())
            ->method('getDiscount')
            ->willReturn(0.23);

        $item->expects($this->any())
            ->method('getQuantity')
            ->willReturn(1);

        $this->sut->addItem($item);
        $this->sut->addItem($item);

        $result = json_encode($this->sut);

        $expected = '{"currency":"USD","value":2,"items":[{},{}]}';
        $this->assertSame($expected, $result);
    }
}
