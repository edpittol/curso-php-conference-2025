<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BrazilianCheckout\Hook;

use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;
use WP_Error;

class CpfCheckoutField
{
    public const string FIELD_NAME = 'cpf';

    public function __construct(
        private readonly PluginService $pluginService
    ) {
        add_action('woocommerce_init', $this->registerCpfField(...));
        add_action('woocommerce_validate_additional_field', $this->validateCpfField(...), 10, 3);
    }

    public function registerCpfField(): void
    {
        woocommerce_register_additional_checkout_field(
            [
                'id' => $this->pluginService->slug() . '/' . self::FIELD_NAME,
                'label' => 'CPF',
                'location' => 'contact',
                'required' => true
            ],
        );
    }

    public function validateCpfField(WP_Error $wpError, string $field_key, string $field_value): void
    {
        if ('curso-php-conference-2025/cpf' === $field_key) {
            $match = preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}/', $field_value);
            if (0 === $match || false === $match) {
                $wpError->add('invalid_cpf', 'Enter a CPF in the format XXX.XXX.XXX-XX.');
            }
        }
    }
}
