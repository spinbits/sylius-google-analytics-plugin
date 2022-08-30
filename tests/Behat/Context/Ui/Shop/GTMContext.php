<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Behat\Page\Shop\Homepage;
use Webmozart\Assert\Assert;

class GTMContext implements Context
{
    /** @var Homepage */
    private $homepage;

    /**
     * @param Homepage $homepage
     */
    public function __construct(Homepage $homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @When a customer with an unknown name visits home page
     */
    public function customerWithUnknownNameVisitsHomePage(): void
    {
        $this->homepage->open();
    }

    /**
     * @When a customer named :name visits home page
     */
    public function namedCustomerVisitsHomePage(string $name): void
    {
        $this->homepage->open(['name' => $name]);
    }

    /**
     * @Then they should have existing gtm id :gtm_id
     */
    public function theyShouldHaveExistingGTMId(string $gtm_id): void
    {
        Assert::true($this->homepage->contains($gtm_id));
    }
}
