<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto;

class Item implements \JsonSerializable, ItemInterface
{
    use JsonSerializeTrait;

    private string $item_id;
    private string $item_name;
    private ?string $affiliation;
    private ?string $coupon;
    private ?string $currency;
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
    private ?int $quantity;

    public function __construct(
        string $item_id,
        string $item_name,
        float $price,
        string $currency,
        ?string $affiliation = null,
        ?string $coupon = null,
        float $discount = 0,
        ?int $index = null,
        ?string $item_brand = null,
        ?array $item_category = null,
        ?string $item_list_id = null,
        ?string $item_list_name = null,
        ?string $item_variant = null,
        ?string $location_id = null,
        int $quantity = 1
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

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string|null $affiliation
     * @return Item
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    /**
     * @param string|null $coupon
     * @return Item
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @param string|null $currency
     * @return Item
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param float|null $discount
     * @return Item
     */
    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @param int|null $index
     * @return Item
     */
    public function setIndex(?int $index): self
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param string|null $item_brand
     * @return Item
     */
    public function setItemBrand(?string $item_brand): self
    {
        $this->item_brand = $item_brand;
        return $this;
    }

    /**
     * @param string|null $item_list_id
     * @return Item
     */
    public function setItemListId($item_list_id)
    {
        $this->item_list_id = $item_list_id;
        return $this;
    }

    /**
     * @param string|null $item_list_name
     * @return Item
     */
    public function setItemListName($item_list_name)
    {
        $this->item_list_name = $item_list_name;
        return $this;
    }

    /**
     * @param string|null $item_variant
     * @return Item
     */
    public function setItemVariant($item_variant)
    {
        $this->item_variant = $item_variant;
        return $this;
    }

    /**
     * @param string|null $location_id
     * @return Item
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }

    /**
     * @param float|null $price
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param int|int|null $quantity
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
}
