<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;

class PromotionItem extends Item
{
    private ?string $creative_name = null;
    private ?string $creative_slot = null;
    private ?string $promotion_id = null;
    private ?string $promotion_name = null;

    public function setCreativeName(?string $creative_name): PromotionItem
    {
        $this->creative_name = $creative_name;
        return $this;
    }

    public function setCreativeSlot(?string $creative_slot): PromotionItem
    {
        $this->creative_slot = $creative_slot;
        return $this;
    }

    public function setPromotionId(?string $promotion_id): PromotionItem
    {
        $this->promotion_id = $promotion_id;
        return $this;
    }

    public function setPromotionName(?string $promotion_name): PromotionItem
    {
        $this->promotion_name = $promotion_name;
        return $this;
    }
}
