<?php

/**
 * Plugin Name: Curso PHP Conference 2025
 * Description: Desenvolvendo conhecimento em programação PHP para WordPress.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 8.4
 * Author: Eduardo Pittol
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: curso-php-conference-2025
 * Domain Path: /languages
 */

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin;

use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\BoletoGateway;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;
use EdPittol\CursoPhpConference2025Plugin\BrazilianCheckout\BrazilianCheckout;
use EdPittol\CursoPhpConference2025Plugin\Customer\Customer;
use EdPittol\CursoPhpConference2025Plugin\Customer\Service\CustomerOrderService;
use EdPittol\CursoPhpConference2025Plugin\DummyGateway\DummyGateway;
use WP_Http;

require_once __DIR__ . '/vendor/autoload.php';

$pluginService = new PluginService();

$httpClient = new WP_Http();

assert(isset($_ENV['ASAAS_API_KEY']) && \is_string($_ENV['ASAAS_API_KEY']));
$apiKey = sanitize_text_field(wp_unslash($_ENV['ASAAS_API_KEY']));

$asaasClient = new AsaasClient($httpClient, $apiKey);

$customerOrderService = new CustomerOrderService($asaasClient);

(new BoletoGateway($pluginService, $asaasClient));
(new BrazilianCheckout($pluginService));
(new Customer($customerOrderService));
(new DummyGateway($pluginService));
