<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Login;
use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Events\Signup;

class AuthEventFactory
{
    public function login(?string $method = null): Login
    {
        return (new Login())
            ->setMethod($method);
    }

    public function signup(?string $method = null): Signup
    {
        return (new Signup())
            ->setMethod($method);
    }
}
