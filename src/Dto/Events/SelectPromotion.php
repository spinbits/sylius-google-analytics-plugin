<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;


use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\Item;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\ItemInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\PromotionItem;

class SelectPromotion extends ItemsContainerEvent implements EventInterface
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

    /**
     * @param string|null $creative_name
     * @return SelectPromotion
     */
    public function setCreativeName(?string $creative_name): SelectPromotion
    {
        $this->creative_name = $creative_name;
        return $this;
    }

    /**
     * @param string|null $creative_slot
     * @return SelectPromotion
     */
    public function setCreativeSlot(?string $creative_slot): SelectPromotion
    {
        $this->creative_slot = $creative_slot;
        return $this;
    }

    /**
     * @param string|null $location_id
     * @return SelectPromotion
     */
    public function setLocationId(?string $location_id): SelectPromotion
    {
        $this->location_id = $location_id;
        return $this;
    }

    /**
     * @param string|null $promotion_id
     * @return SelectPromotion
     */
    public function setPromotionId(?string $promotion_id): SelectPromotion
    {
        $this->promotion_id = $promotion_id;
        return $this;
    }

    /**
     * @param string|null $promotion_name
     * @return SelectPromotion
     */
    public function setPromotionName(?string $promotion_name): SelectPromotion
    {
        $this->promotion_name = $promotion_name;
        return $this;
    }

    /**
     * @param PromotionItem|Item|ItemInterface $item
     */
    protected function calculate(ItemInterface $item): void{}
}
