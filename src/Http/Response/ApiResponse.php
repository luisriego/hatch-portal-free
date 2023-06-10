<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse
{
    public function __construct(array $data, int $status = Response::HTTP_OK)
    {
        parent::__construct($data, $status);
    }
}
