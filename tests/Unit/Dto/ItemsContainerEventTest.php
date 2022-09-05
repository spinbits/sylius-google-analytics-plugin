<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ItemsContainerEventTest extends TestCase
{
    /** @var ItemsContainerEvent */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new ItemsContainerEvent();
    }

    /** @test */
    public function testAddItem()
    {
        $item = new Item('id', 'name', 2.50, 'USD');
        $item->setDiscount(0.7);

        $this->sut->addItem($item);
        $this->sut->addItem($item);

        $this->assertSame('USD', $this->sut->getCurrency());
        $this->assertSame(3.6, $this->sut->getValue());
    }
}
