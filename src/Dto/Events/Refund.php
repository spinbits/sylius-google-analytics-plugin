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

class Refund implements EventInterface
{
    use JsonSerializeTrait;

    private string $transaction_id;
    private ?string $affiliation = null;
    private ?string $coupon = null;
    private ?float $shipping = null;
    private ?float $tax = null;

    /**
     * @param string $transaction_id
     */
    public function __construct(string $transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function getName(): string
    {
        return 'refund';
    }

    /**
     * @param string|null $affiliation
     * @return Refund
     */
    public function setAffiliation(?string $affiliation): Refund
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    /**
     * @param string|null $coupon
     * @return Refund
     */
    public function setCoupon(?string $coupon): Refund
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @param float|null $shipping
     * @return Refund
     */
    public function setShipping(?float $shipping): Refund
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @param float|null $tax
     * @return Refund
     */
    public function setTax(?float $tax): Refund
    {
        $this->tax = $tax;
        return $this;
    }
}
