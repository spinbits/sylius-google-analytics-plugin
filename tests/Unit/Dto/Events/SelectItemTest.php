<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\SelectItem;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemInterface;

class SelectItemTest extends TestCase
{
    /** @var SelectItem */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new SelectItem();
    }

    public function testGetName()
    {
        $this->assertSame('select_item', $this->sut->getName());
    }

    public function testSerializeMockItem()
    {
        $item=$this->createMock(ItemInterface::class);

        $this->sut->addItem($item);
        $this->sut->setItemListId('list_id');
        $this->sut->setItemListName('list_name');

        $result = json_encode($this->sut);

        $expected = '{"item_list_id":"list_id","item_list_name":"list_name","items":[{}]}';
        $this->assertEqualsCanonicalizing(json_decode($expected, true), json_decode($result, true));
    }
}
