<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\EventInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class SelectPromotion implements EventInterface
{
    use JsonSerializeTrait;

    private ?string $creative_name = null;
    private ?string $creative_slot = null;
    private ?string $location_id = null;
    private ?string $promotion_id = null;
    private ?string  $promotion_name = null;

    public function getName(): string
    {
        return 'select_promotion';
    }
}
