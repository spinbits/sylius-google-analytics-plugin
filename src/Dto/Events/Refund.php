<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

class Refund
{
    private string $currency;
    private $transaction_id;
    private float $value;
    private $affiliation;
    private ?string $coupon;
    private $shipping;
    private $tax;
    private array $items = [];

    private $isFullRefund = false;

    public function getName(): string
    {
        return 'refund';
    }
}
