<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Webhook\Hook;

use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;
use EdPittol\CursoPhpConference2025Plugin\Webhook\Service\WebhookPaymentService;
use Exception;
use WP_REST_Request;
use WP_REST_Response;

class WebhookEndpoint
{
    public function __construct(
        private readonly PluginService $pluginService
    ) {
        add_action('rest_api_init', $this->registerApiRoute(...));
    }

    public function registerApiRoute(): void
    {
        register_rest_route($this->pluginService->slug() . '/v1', '/webhook', [
            'methods' => 'POST',
            'callback' => $this->processWebhook(...),
        ]);
    }

    /**
     * @param WP_REST_Request<array<string,mixed>> $wpRestRequest
     */
    public function processWebhook(WP_REST_Request $wpRestRequest): WP_REST_Response
    {
        /**
         * @var array{
         *     payment: array{
         *         status: string,
         *         id: string
         *     }
         * } $object
         */
        $object = $wpRestRequest->get_json_params();

        try {
            (new WebhookPaymentService())->processEvent(
                (string) $object['payment']['status'],
                (string) $object['payment']['id']
            );
        } catch (Exception $exception) {
            return new WP_REST_Response($exception->getMessage(), 400);
        }

        return new WP_REST_Response('Order set as paid', 200);
    }
}
