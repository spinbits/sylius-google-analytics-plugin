<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Search;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemInterface;

class SearchTest extends TestCase
{
    /** @var Search */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new Search('example_term');
    }

    public function testGetName()
    {
        $this->assertSame('search', $this->sut->getName());
    }

    public function testSerializeMockItem()
    {
        $item=$this->createMock(ItemInterface::class);

        $result = json_encode($this->sut);

        $expected = '{"search_term":"example_term"}';
        $this->assertSame($expected, $result);
    }
}
