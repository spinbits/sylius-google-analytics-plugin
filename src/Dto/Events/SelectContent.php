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

class SelectContent implements \JsonSerializable
{
    use JsonSerializeTrait;

    private ?string $content_type;
    private ?string $item_id;

    public function getName(): string
    {
        return 'select_content';
    }

    /**
     * @param string|null $content_type
     * @return SelectContent
     */
    public function setContentType(?string $content_type): SelectContent
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * @param string|null $item_id
     * @return SelectContent
     */
    public function setItemId(?string $item_id): SelectContent
    {
        $this->item_id = $item_id;
        return $this;
    }
}
