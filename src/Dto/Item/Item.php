<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class Item implements \JsonSerializable, ItemInterface
{
    use JsonSerializeTrait;

    private string $item_id;
    private string $item_name;
    private ?string $affiliation;
    private ?string $coupon;
    private string $currency;
    private ?float $discount;
    private ?int $index;
    private ?string $item_brand;
    private ?string $item_category = null;
    private ?string $item_category2 = null;
    private ?string $item_category3 = null;
    private ?string $item_category4 = null;
    private ?string $item_category5 = null;
    private ?string $item_list_id;
    private ?string $item_list_name;
    private ?string $item_variant;
    private ?string $location_id;
    private ?float $price;
    private int $quantity;

    public function __construct(
        string $item_id,
        string $item_name,
        float $price,
        string $currency,
        float $discount = 0,
        int $quantity = 1,
        ?string $affiliation = null,
        ?string $coupon = null,
        ?int $index = null,
        ?string $item_brand = null,
        ?array $item_category = null,
        ?string $item_list_id = null,
        ?string $item_list_name = null,
        ?string $item_variant = null,
        ?string $location_id = null
    ) {
        $this->item_id = $item_id;
        $this->item_name = $item_name;
        $this->affiliation = $affiliation;
        $this->coupon = $coupon;
        $this->currency = $currency;
        $this->discount = $discount;
        $this->index = $index;
        $this->item_brand = $item_brand;
        $this->item_list_id = $item_list_id;
        $this->item_list_name = $item_list_name;
        $this->item_variant = $item_variant;
        $this->location_id = $location_id;
        $this->price = $price;
        $this->quantity = $quantity;

        if (is_array($item_category)) {
            $this->item_category = (count($item_category)>0) ? (string) array_shift($item_category) : null;
            $this->item_category2 = (count($item_category)>0) ? (string) array_shift($item_category) : null;
            $this->item_category3 = (count($item_category)>0) ? (string) array_shift($item_category) : null;
            $this->item_category4 = (count($item_category)>0) ? (string) array_shift($item_category) : null;
            $this->item_category5 = (count($item_category)>0) ? (string) array_shift($item_category) : null;
        }
    }

    public function getValue(): float
    {
        return ((float) $this->price - (float) $this->discount) * $this->quantity;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setAffiliation(?string $affiliation): Item
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    public function setCoupon(?string $coupon): Item
    {
        $this->coupon = $coupon;
        return $this;
    }

    public function setDiscount(?float $discount): Item
    {
        $this->discount = $discount;
        return $this;
    }

    public function setIndex(?int $index): Item
    {
        $this->index = $index;
        return $this;
    }

    public function setItemBrand(?string $item_brand): Item
    {
        $this->item_brand = $item_brand;
        return $this;
    }

    public function setItemListId(?string $item_list_id): Item
    {
        $this->item_list_id = $item_list_id;
        return $this;
    }

    public function setItemListName(?string $item_list_name): Item
    {
        $this->item_list_name = $item_list_name;
        return $this;
    }

    public function setItemVariant(?string $item_variant): Item
    {
        $this->item_variant = $item_variant;
        return $this;
    }

    public function setLocationId(?string $location_id): Item
    {
        $this->location_id = $location_id;
        return $this;
    }

    public function setPrice(?float $price): Item
    {
        $this->price = $price;
        return $this;
    }

    public function setQuantity(int $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }
}
