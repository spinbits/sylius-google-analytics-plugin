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

class AddShippingInfo extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $coupon = null;
    private ?string $shipping_tier = null;

    public function getName(): string
    {
        return 'add_shipping_info';
    }

    /**
     * @param string|null $coupon
     * @return AddShippingInfo
     */
    public function setCoupon(?string $coupon): AddShippingInfo
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @param string|null $shipping_tier
     * @return AddShippingInfo
     */
    public function setShippingTier(?string $shipping_tier): AddShippingInfo
    {
        $this->shipping_tier = $shipping_tier;
        return $this;
    }
}
