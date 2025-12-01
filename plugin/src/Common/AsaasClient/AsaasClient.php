<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient;

use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\Exception\AsaasClientRequestException;
use Exception;
use WP_Error;
use WP_Http;
use WP_HTTP_Requests_Response;
use WpOrg\Requests\Response;

class AsaasClient
{
    public function __construct(
        private readonly WP_Http $wpHttp,
        private readonly string $apiKey
    ) {
    }

    public function apiKey(): string
    {
        return $this->apiKey;
    }

    public function baseUrl(): string
    {
        return 'https://sandbox.asaas.com/api/v3';
    }

    private function url(string $endpoint): string
    {
        return $this->baseUrl() . '/' . ltrim($endpoint, '/');
    }

    /**
     * @param array<string,string> $queryParams
     */
    public function get(string $endpoint, array $queryParams = []): Response
    {
        return $this->request('GET', $endpoint, $queryParams);
    }

    /**
     * @param array<string,mixed> $data
     */
    public function post(string $endpoint, array $data): Response
    {
        return $this->request('POST', $endpoint, $data);
    }

    /**
     * @param array<string,mixed> $data
     * @throws AsaasClientRequestException
     */
    private function request(string $method, string $endpoint, array $data = []): Response
    {
        $url = $this->url($endpoint);
        $method = strtoupper($method);

        $args = [];

        if ($method === 'POST') {
            $args['body'] = $this->encodeBody($data);
        } elseif ($method === 'GET' && $data !== []) {
            $url .= '?' . http_build_query($data);
        }

        $args['headers'] = [
            'access_token' => $this->apiKey(),
            'Content-Type'  => 'application/json',
        ];

        $response = $this->wpHttp->request($url, array_merge($args, [
            'method' => $method,
        ]));

        return $this->extractResponseObject($response);
    }

    /**
     * @param array<string,mixed> $data
     */
    private function encodeBody(array $data): string
    {
        $dataEncoded = wp_json_encode($data);

        if ($dataEncoded === false) {
            throw new Exception('Failed to encode data to JSON.');
        }

        return $dataEncoded;
    }

    /**
     * @param array{
     *   headers: \WpOrg\Requests\Utility\CaseInsensitiveDictionary,
     *   body: string,
     *   response: array{
     *     code: int,
     *     message: string
     *   },
     *   cookies: array<int, \WP_Http_Cookie>,
     *   filename: string|null,
     *   http_response: WP_HTTP_Requests_Response
     * }|WP_Error $response
     */
    private function extractResponseObject($response): Response
    {
        if (is_wp_error($response)) {
            throw new Exception(esc_html($response->get_error_message()));
        }

        $response = $response['http_response']->get_response_object();

        if (!$response->success) {
            throw new AsaasClientRequestException(
                esc_html('Asaas client request failed with status code: ' . $response->status_code),
                // phpcs:ignore WordPress.Security.EscapeOutput -- This is an object not output
                $response
            );
        }

        return $response;
    }
}
