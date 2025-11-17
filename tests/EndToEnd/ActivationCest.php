<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

class ActivationCest
{
    public function test_homepage_works(EndToEndTester $endToEndTester): void
    {
        $endToEndTester->amOnPage('/');
        $endToEndTester->seeElement('body');
    }
    
    public function test_can_login_as_admin(EndToEndTester $endToEndTester): void
    {
        $endToEndTester->loginAsAdmin();
        $endToEndTester->amOnAdminPage('/');
        $endToEndTester->seeElement('body.wp-admin');
    }
}
