<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

class CheckoutCest
{
    public function testCheckout(EndToEndTester $endToEndTester): void
    {
        $endToEndTester->amOnPage('/produto/album/');
        $endToEndTester->click('.single_add_to_cart_button');
        $endToEndTester->waitForElement('.woocommerce-message');

        $endToEndTester->amOnPage('/finalizar-compra/');

        $endToEndTester->fillField('#email', 'joao@teste.com');
        $endToEndTester->fillField('#contact-curso-php-conference-2025-cpf', '958.132.340-63');

        $endToEndTester->selectOption('#billing-country', 'BR');
        $endToEndTester->fillField('#billing-first_name', 'João');
        $endToEndTester->fillField('#billing-last_name', 'Souza');
        $endToEndTester->fillField('#billing-address_1', 'Rua Epaminondas Jácome 123');
        $endToEndTester->fillField('#billing-city', 'Rio Branco');
        $endToEndTester->selectOption('#billing-state', 'AC');
        $endToEndTester->fillField('#billing-postcode', '69905-292');
        $endToEndTester->fillField('#billing-phone', '(68) 98456-1234');

        $endToEndTester->click('#radio-control-wc-payment-method-options-boleto_gateway');

        $endToEndTester->waitForElementClickable('.wc-block-components-checkout-place-order-button');
        $endToEndTester->click('.wc-block-components-checkout-place-order-button');

        $endToEndTester->waitForElement('.woocommerce-order');
        $endToEndTester->see('Pedido recebido', 'h1');

        $bankSlipLink = $endToEndTester->grabFromDatabase('wp_wc_orders_meta', 'meta_value', [
            'order_id' => 58,
            'meta_key' => '_asaas_bank_slip_url',
        ]);

        $endToEndTester->seeLink('Ver Boleto', $bankSlipLink);
    }
}
