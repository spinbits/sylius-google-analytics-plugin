<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\EventsBagSessionFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventsBagSessionFactoryTest extends TestCase
{
    /** @var EventsBagSessionFactory */
    private $sut;

    /** @var MockObject|SessionFactoryInterface  */
    private MockObject $delegate;

    /** @var MockObject| EventsBag eventsBag */
    private EventsBag $eventsBag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->delegate = $this->createMock(SessionFactoryInterface::class);
        $this->eventsBag = $this->createMock(EventsBag::class);

        $this->sut = new EventsBagSessionFactory(
            $this->delegate,
            $this->eventsBag
        );
    }

    public function testCreateSession()
    {
        $session = $this->createMock(SessionInterface::class);

        $this->delegate
            ->expects($this->once())
            ->method('createSession')
            ->willReturn($session);

        $session
            ->expects($this->once())
            ->method('registerBag')
            ->with(...[$this->eventsBag]);

        $result = $this->sut->createSession();

        $this->assertSame($session, $result);
    }
}
