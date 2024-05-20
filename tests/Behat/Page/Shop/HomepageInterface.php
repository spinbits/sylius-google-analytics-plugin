<?php

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Behat\Page\Shop;

interface HomepageInterface
{
    public function contains(string $string): bool;
}
