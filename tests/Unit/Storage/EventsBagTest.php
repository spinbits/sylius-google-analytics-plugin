<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Storage;

use Spinbits\GoogleAnalytics4EventsDtoS\Events\Login;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use PHPUnit\Framework\TestCase;

class EventsBagTest extends TestCase
{
    /** @var EventsBag */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new EventsBag();
    }

    /** @test */
    public function testGetEvents(): void
    {
        $result = $this->sut->getEvents();

        $this->assertEqualsCanonicalizing([], $result);
    }

    /** @test */
    public function testSetEvents(): void
    {
        $this->sut->set('example_event', (new Login())->getName());
        $result = $this->sut->getEvents();

        $this->assertEqualsCanonicalizing([[0]], $result);
    }
}
