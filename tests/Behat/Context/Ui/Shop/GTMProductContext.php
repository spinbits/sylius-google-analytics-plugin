<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Behat\Context\Ui\Shop;

use Webmozart\Assert\Assert;
use Behat\Behat\Context\Context;
use Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Behat\Page\Shop\HomepageInterface;

class GTMProductContext implements Context
{
    public function __construct(
        private HomepageInterface $showPage
    ) {
    }

    /**
     * @Then I should have existing gtm event :event
     */
    public function iShouldHaveExistingGTMEvent(string $eventName): void
    {
        //$searchString = sprintf('gtag("event", "view_item"', $eventName);
        Assert::true($this->showPage->contains('view_item'));
    }
}
