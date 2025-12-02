<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Api\Endpoint;

use RuntimeException;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasEndpoint;
use EdPittol\CursoPhpConference2025Plugin\Customer\Adapter\CustomerToApiRequestAdapter;
use EdPittol\CursoPhpConference2025Plugin\Customer\Data\Customer;
use WpOrg\Requests\Response;

class CustomerEndpoint extends AsaasEndpoint
{
    protected function resourcePath(): string
    {
        return 'customers';
    }

    public function create(Customer $customer): Response
    {
        $endpoint = $this->resourcePath();
        $requestData = new CustomerToApiRequestAdapter()->adapt($customer);

        $response = $this->asaasClient->post($endpoint, $requestData);

        if ($response->status_code >= 400) {
            throw new RuntimeException(esc_html('Error creating customer: ' . $response->status_code));
        }

        return $response;
    }

    /**
     * @param array<string, string> $queryParams
     */
    public function list(array $queryParams = []): Response
    {
        $endpoint = $this->resourcePath();

        return $this->asaasClient->get($endpoint, $queryParams);
    }
}
