<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto;

class Item implements \JsonSerializable
{
    private string $item_id;
    private string $item_name;
    private string $affiliation;
    private string $coupon;
    private string $currency;
    private float $discount;
    private int $index;
    private string $item_brand;
    private array $item_category = [];
    private string $item_list_id;
    private string $item_list_name;
    private string $item_variant;
    private string $location_id;
    private float $price;
    private int $quantity;

    public function __construct(
        string $item_id,
        string $item_name,
        string $affiliation = '',
        string $coupon = '',
        string $currency = '',
        float $discount = 0,
        int $index = 0,
        string $item_brand = '',
        array $item_category = [],
        string $item_list_id = '',
        string $item_list_name = '',
        string $item_variant = '',
        string $location_id = '',
        float $price = 0,
        int $quantity = 0
    ) {
        $this->item_id = $item_id;
        $this->item_name = $item_name;
        $this->affiliation = $affiliation;
        $this->coupon = $coupon;
        $this->currency = $currency;
        $this->discount = $discount;
        $this->index = $index;
        $this->item_brand = $item_brand;
        $this->item_category = $item_category;
        $this->item_list_id = $item_list_id;
        $this->item_list_name = $item_list_name;
        $this->item_variant = $item_variant;
        $this->location_id = $location_id;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function jsonSerialize()
    {
        $result = [
            'item_id' => $this->item_id,
            'item_name' => $this->item_name,
            'affiliation' => $this->affiliation,
            'coupon' => $this->coupon,
            'currency' => $this->currency,
            'discount' => $this->discount,
            'index' => $this->index,
            'item_brand' => $this->item_brand,
            'item_list_id' => $this->item_list_id,
            'item_list_name' => $this->item_list_name,
            'item_variant' => $this->item_variant,
            'location_id' => $this->location_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];

        $i = 0;
        foreach($this->item_category as $name => $value) {
            $i++;
            $result['item_category'.$i] = $value;
        }

        return $result;
    }
}
