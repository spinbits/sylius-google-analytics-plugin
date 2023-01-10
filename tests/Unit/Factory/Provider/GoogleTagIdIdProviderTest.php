<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Factory\Provider;

use Spinbits\SyliusGoogleAnalytics4Plugin\Provider\GoogleTagIdIdProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Channel;

class GoogleTagIdIdProviderTest extends TestCase
{
    private GoogleTagIdIdProvider|MockObject $sut;
    private ChannelContextInterface|MockObject $channelContext;

    protected function setUp(): void
    {
        parent::setUp();

        $channel = $this->createMock(Channel::class);
        $channel->expects($this->once())
            ->method('getCode')
            ->willReturn('CHANNEL');

        $this->channelContext = $this->createMock(ChannelContextInterface::class);
        $this->channelContext->expects($this->once())
            ->method('getChannel')
            ->willReturn($channel);

        $this->sut = new GoogleTagIdIdProvider($this->channelContext, 'id', ['CHANNEL' => 'some-id']);
    }

    /** @test */
    public function testProvidePerChannel()
    {
        $this->assertSame('some-id', $this->sut->provide());
    }

    /** @test */
    public function testProvidePerDefault()
    {
        $this->sut = new GoogleTagIdIdProvider($this->channelContext, 'id', ['OTHER' => 'some-id']);
        $this->assertSame('id', $this->sut->provide());
    }
}
