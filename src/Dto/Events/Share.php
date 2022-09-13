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

class Share implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $method = null;
    private ?string $content_type = null;
    private ?string $item_id = null;

    public function getName(): string
    {
        return 'share';
    }

    /**
     * @param string|null $method
     * @return Share
     */
    public function setMethod(?string $method): Share
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string|null $content_type
     * @return Share
     */
    public function setContentType(?string $content_type): Share
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * @param string|null $item_id
     * @return Share
     */
    public function setItemId(?string $item_id): Share
    {
        $this->item_id = $item_id;
        return $this;
    }
}
