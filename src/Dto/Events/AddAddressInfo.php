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

class AddAddressInfo extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $coupon = null;

    public function getName(): string
    {
        return 'add_address_info';
    }

    /**
     * @param string|null $coupon
     * @return AddAddressInfo
     */
    public function setCoupon(?string $coupon): AddAddressInfo
    {
        $this->coupon = $coupon;
        return $this;
    }
}
