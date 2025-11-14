<?php

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

class CheckoutCest
{
    public function testCheckout(EndToEndTester $I): void
    {
        $I->amOnPage('/produto/single/');
        $I->click('.single_add_to_cart_button');
        $I->waitForElement('.woocommerce-message');

        $I->amOnPage('/finalizar-compra/');

        $I->fillField('#email', 'joao@teste.com');
        $I->selectOption('#billing-country', 'BR');
        $I->fillField('#billing-first_name', 'João');
        $I->fillField('#billing-last_name', 'Souza');
        $I->fillField('#billing-address_1', 'Rua Epaminondas Jácome 123');
        $I->fillField('#billing-city', 'Rio Branco');
        $I->selectOption('#billing-state', 'AC');
        $I->fillField('#billing-postcode', '69905-292');
        $I->fillField('#billing-phone', '(68) 98456-1234');

        $I->waitForElementClickable('.wc-block-components-checkout-place-order-button');
        $I->click('.wc-block-components-checkout-place-order-button');

        $I->waitForElement('.woocommerce-order');
        $I->see('Pedido recebido', 'h1');
    }
}
