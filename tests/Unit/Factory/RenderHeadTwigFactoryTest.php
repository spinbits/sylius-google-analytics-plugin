<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit;

use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\RenderHeadTwigFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Channel;
use Twig\Environment;

class RenderHeadTwigFactoryTest extends TestCase
{
    /** @var RenderHeadTwigFactory */
    private $sut;

    /** @var MockObject|Environment */
    private MockObject $twig;

    /** @var MockObject|ChannelContextInterface */
    private MockObject $channelContext;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twig = $this->createMock(Environment::class);
        $this->channelContext = $this->createMock(ChannelContextInterface::class);

        $this->sut = new RenderHeadTwigFactory(
            $this->channelContext,
            $this->twig,
            'id',
            'param',
            'template',
            true,
            ['CHANNEL' => 'G-123123123']
        );
    }

    public function testRenderEnabled()
    {
        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with(...['template',['id' => 'id',
                'url_suffix'=> '&param']])
            ->willReturn('example content');

        $this->sut->render();
    }

    public function testRenderDisabled()
    {
        $this->sut = new RenderHeadTwigFactory($this->channelContext, $this->twig, '', '', '', false);
        $this->twig
            ->expects($this->never())
            ->method('render')
            ->willReturn('');

        $result = $this->sut->render();
        $this->assertSame('', $result);
    }

    public function testRenderWithDefaultGtagId()
    {
        $channel = $this->createMock(Channel::class);
        $channel->expects($this->once())
            ->method('getCode')
            ->willReturn('OTHER_CHANNEL');

        $this->channelContext->expects($this->once())
            ->method('getChannel')
            ->willReturn($channel);

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with(...['template', [
                'id' => 'id',
                'url_suffix' => '&param'
            ]])
            ->willReturn('example content');

        $this->sut->render();
    }

    public function testRenderWithDedicatedGtagId()
    {
        $channel = $this->createMock(Channel::class);
        $channel->expects($this->once())
            ->method('getCode')
            ->willReturn('CHANNEL');

        $this->channelContext->expects($this->once())
            ->method('getChannel')
            ->willReturn($channel);

        $this->twig->expects($this->once())
            ->method('render')
            ->with(...['template', [
                'id' => 'G-123123123',
                'url_suffix' => '&param'
            ]]);

        $this->sut->render();
    }
}
