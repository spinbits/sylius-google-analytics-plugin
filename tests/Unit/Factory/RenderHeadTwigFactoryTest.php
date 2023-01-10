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
use Spinbits\SyliusGoogleAnalytics4Plugin\Provider\GoogleTagIdProviderInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\Channel;
use Twig\Environment;

class RenderHeadTwigFactoryTest extends TestCase
{
    /** @var RenderHeadTwigFactory */
    private $sut;

    /** @var MockObject|Environment */
    private MockObject $twig;

    /** @var MockObject|GoogleTagIdProviderInterface */
    private MockObject $googleTagIdProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twig = $this->createMock(Environment::class);
        $this->googleTagIdProvider = $this->createMock(GoogleTagIdProviderInterface::class);

        $this->sut = new RenderHeadTwigFactory(
            $this->googleTagIdProvider,
            $this->twig,
            'param',
            'template',
            true,
        );
    }

    public function testRenderEnabled()
    {
        $this->googleTagIdProvider
            ->expects($this->once())
            ->method('provide')
            ->willReturn('id');

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
        $this->sut = new RenderHeadTwigFactory($this->googleTagIdProvider, $this->twig, '', '', false);

        $this->googleTagIdProvider
            ->expects($this->never())
            ->method('provide');

        $this->twig
            ->expects($this->never())
            ->method('render')
            ->willReturn('');

        $result = $this->sut->render();
        $this->assertSame('', $result);
    }
}
