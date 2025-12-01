<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\Exception;

use Exception;
use WpOrg\Requests\Response;

class AsaasClientRequestException extends Exception
{
    private readonly Response $response;

    public function __construct(string $message, Response $response)
    {
        parent::__construct($message);
        $this->response = $response;
    }

    public function response(): Response
    {
        return $this->response;
    }
}
