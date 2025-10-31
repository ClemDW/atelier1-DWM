<?php

namespace charlymatloc\api\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $origin = $request->getHeaderLine('Origin');

        if ($request->getMethod() === 'OPTIONS') {
            $response = new \Slim\Psr7\Response();
            $response = $this->addCorsHeaders($response, $origin, $request);
            return $response->withStatus(200);
        }

        $response = $handler->handle($request);
        return $this->addCorsHeaders($response, $origin, $request);
    }


    private function addCorsHeaders(ResponseInterface $response, string $origin = '', ?ServerRequestInterface $request = null): ResponseInterface
    {
        $allowed = $_ENV['CORS_ALLOWED_ORIGINS'] ?? ($_ENV['url'] ?? '');
        $allowedOrigins = array_filter(array_map('trim', explode(',', $allowed)));

        $allowOrigin = '';
        if ($origin && in_array($origin, $allowedOrigins, true)) {
            $allowOrigin = $origin;
        } elseif (!empty($allowedOrigins[0])) {
            $allowOrigin = $allowedOrigins[0];
        }

        $response = $response->withHeader('Access-Control-Allow-Origin', $allowOrigin ?: '*')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '86400');

        $requestHeaders = $request ? $request->getHeaderLine('Access-Control-Request-Headers') : '';
        if (empty($requestHeaders)) {
            $requestHeaders = 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-API-Key';
        }

        $requestMethod = $request ? $request->getHeaderLine('Access-Control-Request-Method') : '';
        if (empty($requestMethod)) {
            $requestMethod = 'GET, POST, PUT, DELETE, PATCH, OPTIONS';
        }

        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders)
            ->withHeader('Access-Control-Allow-Methods', $requestMethod);

        return $response;
    }
}