<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Resolver;

use Symfony\Component\HttpFoundation\Request;

class EventResolver
{
    private const DEFAULT_MAP = [
        'sylius_shop_product_show' => 'view_item',
        'sylius_shop_cart_summary' => 'view_cart',
        'sylius_shop_cart_save' => 'add_to_cart',
        'sylius_shop_ajax_cart_add_item' => 'add_to_cart',
        'sylius_shop_cart_item_remove' => 'remove_from_cart',
        'sylius_shop_ajax_cart_item_remove' => 'remove_from_cart',
        'sylius_shop_checkout_start' => 'begin_checkout',
        'sylius_shop_checkout_select_payment' => 'add_payment_info',
        'sylius_shop_checkout_select_shipping' => 'add_shipping_info',
        'sylius_shop_checkout_complete' => 'purchase',
        'sylius_shop_login_check' => 'login',
        'sylius_shop_register' => 'sign_up',
        'sylius_shop_register_after_checkout' => 'sign_up',
        'sylius_shop_product_index' => 'view_item_list'
    ];

    /**
     * @var array|string[] routesEventsMap
     */
    private array $routesEventsMap;

    public function __construct(array $routesEventsMap = [])
    {
        $this->routesEventsMap = $routesEventsMap === [] ? self::DEFAULT_MAP : $routesEventsMap ;
    }

    public function resolve(Request $request): string
    {
        $routeName = $request->attributes->get('_route');

        return isset($this->routesEventsMap[$routeName]) ? $this->routesEventsMap[$routeName] : $routeName;
    }
}
