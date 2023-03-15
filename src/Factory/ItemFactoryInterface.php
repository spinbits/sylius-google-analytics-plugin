<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory;

use Spinbits\GoogleAnalytics4EventsDtoS\Item\Item;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Product\Model\ProductInterface;

interface ItemFactoryInterface
{
    public function fromProduct(ProductInterface $product): Item;
    public function fromOrderItem(OrderItemInterface $orderItem): Item;
}
