<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\ItemsContainerEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class Purchase extends ItemsContainerEvent implements \JsonSerializable
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
        return 'purchase';
    }

    /**
     * @param string|null $affiliation
     * @return Purchase
     */
    public function setAffiliation(?string $affiliation): Purchase
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    /**
     * @param string|null $coupon
     * @return Purchase
     */
    public function setCoupon(?string $coupon): Purchase
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @param float|null $shipping
     * @return Purchase
     */
    public function setShipping(?float $shipping): Purchase
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @param float|null $tax
     * @return Purchase
     */
    public function setTax(?float $tax): Purchase
    {
        $this->tax = $tax;
        return $this;
    }
}
