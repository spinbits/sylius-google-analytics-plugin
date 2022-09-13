<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Signup;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\ItemInterface;

class SignupTest extends TestCase
{
    /** @var Signup */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new Signup();
    }

    public function testGetName()
    {
        $this->assertSame('sign_up', $this->sut->getName());
    }

    public function testSerializeMockItem()
    {
        $item=$this->createMock(ItemInterface::class);

        $this->sut->setMethod('example');

        $result = json_encode($this->sut);

        $expected = '{"method":"example"}';
        $this->assertSame($expected, $result);
    }
}
