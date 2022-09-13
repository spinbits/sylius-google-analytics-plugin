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

class AddPaymentInfo extends ItemsContainerEvent implements \JsonSerializable, EventInterface
{
    use JsonSerializeTrait;

    private ?string $coupon = null;
    private ?string $payment_type = null;

    public function getName(): string
    {
        return 'add_payment_info';
    }

    /**
     * @param string|null $coupon
     * @return AddPaymentInfo
     */
    public function setCoupon(?string $coupon): AddPaymentInfo
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @param string|null $payment_type
     * @return AddPaymentInfo
     */
    public function setPaymentType(?string $payment_type): AddPaymentInfo
    {
        $this->payment_type = $payment_type;
        return $this;
    }
}
