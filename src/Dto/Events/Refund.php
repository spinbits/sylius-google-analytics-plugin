<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\EventInterface;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\JsonSerializeTrait;

class Refund implements EventInterface
{
    use JsonSerializeTrait;

    private ?string $transaction_id = null;
    private ?string $affiliation = null;
    private ?string $coupon = null;
    private ?float $shipping = null;
    private ?float $tax = null;

    private bool $isFullRefund = false;

    public function getName(): string
    {
        return 'refund';
    }
}
