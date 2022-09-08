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
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;

class ViewPromotion extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $creative_name = null;
    private ?string $creative_slot = null;
    private ?string $location_id = null;
    private ?string $promotion_id = null;
    private ?string $promotion_name = null;

    public function getName(): string
    {
        return 'view_promotion';
    }

    /**
     * @param string $creative_name
     * @return ViewPromotion
     */
    public function setCreativeName(string $creative_name): ViewPromotion
    {
        $this->creative_name = $creative_name;
        return $this;
    }

    /**
     * @param string $creative_slot
     * @return ViewPromotion
     */
    public function setCreativeSlot(string $creative_slot): ViewPromotion
    {
        $this->creative_slot = $creative_slot;
        return $this;
    }

    /**
     * @param string $location_id
     * @return ViewPromotion
     */
    public function setLocationId(string $location_id): ViewPromotion
    {
        $this->location_id = $location_id;
        return $this;
    }

    /**
     * @param string $promotion_id
     * @return ViewPromotion
     */
    public function setPromotionId(string $promotion_id): ViewPromotion
    {
        $this->promotion_id = $promotion_id;
        return $this;
    }

    /**
     * @param string $promotion_name
     * @return ViewPromotion
     */
    public function setPromotionName(string $promotion_name): ViewPromotion
    {
        $this->promotion_name = $promotion_name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function calculate(Item $item): void{}
}
