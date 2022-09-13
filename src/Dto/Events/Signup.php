<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;


use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class Signup implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $method = null;

    public function getName(): string
    {
        return 'sign_up';
    }

    /**
     * @param string|null $method
     * @return Signup
     */
    public function setMethod(?string $method): Signup
    {
        $this->method = $method;
        return $this;
    }
}
