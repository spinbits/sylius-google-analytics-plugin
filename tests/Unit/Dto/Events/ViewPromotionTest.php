<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\ViewPromotion;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemInterface;

class ViewPromotionTest extends TestCase
{
    /** @var ViewPromotion */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new ViewPromotion();
    }

    public function testGetName()
    {
        $this->assertSame('view_promotion', $this->sut->getName());
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

        $this->sut->setCreativeName('name');
        $this->sut->setCreativeSlot('slot');
        $this->sut->setLocationId('id');
        $this->sut->setPromotionId('promo_id');
        $this->sut->setPromotionName('promo_name');

        $result = json_encode($this->sut);

        $expected = '{"creative_name":"name","creative_slot":"slot","location_id":"id","promotion_id":"promo_id","promotion_name":"promo_name","items":[{},{}]}';
        $this->assertEqualsCanonicalizing(json_decode($expected, true), json_decode($result, true));
    }
}
