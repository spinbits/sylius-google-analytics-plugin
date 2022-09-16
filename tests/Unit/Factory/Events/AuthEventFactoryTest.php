<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\AuthEventFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AuthEventFactoryTest extends TestCase
{
    /** @var AuthEventFactory */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new AuthEventFactory();
    }

    /** @test */
    public function testSignup()
    {
        $result = $this->sut->signup('example');

        $this->assertSame('sign_up', $result->getName());
        $this->assertSame('{"method":"example"}', (string) $result);
    }

    /** @test */
    public function testLogin()
    {
        $result = $this->sut->login('example');

        $this->assertSame('login', $result->getName());
        $this->assertSame('{"method":"example"}', (string) $result);
    }
}
