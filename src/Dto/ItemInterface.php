<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto;

interface ItemInterface{

    public function getCurrency(): string;
    public function getPrice(): float;
    public function getDiscount(): float;
    public function getQuantity(): int;

}
