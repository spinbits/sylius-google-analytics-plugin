<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

class SelectPromotion
{
    private $creative_name;
    private $creative_slot;
    private $location_id;
    private $promotion_id;
    private $promotion_name;
    private array $items = [];

    public function getName(): string
    {
        return 'select_promotion';
    }
}
