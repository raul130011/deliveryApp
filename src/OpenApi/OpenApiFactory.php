<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ArrayObject;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

//Security section
        $securitySchemes = $openApi->getComponents()->getSecuritySchemes();
        $securitySchemes['bearerAuth'] = new ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT'
        ]);

//hidden a route
        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getGet() && $path->getGet()->getSummary() === 'hiddenGet') {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getPut() && $path->getPut()->getSummary() === 'hiddenPut') {
                $openApi->getPaths()->addPath($key, $path->withPut(null));
            }
        }

        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getDelete() && $path->getDelete()->getSummary() === 'hiddenDelete') {
                $openApi->getPaths()->addPath($key, $path->withDelete(null));
            }
        }

        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getPost() && $path->getPost()->getSummary() === 'hiddenPost') {
                $openApi->getPaths()->addPath($key, $path->withPost(null));
            }
        }
        return $openApi;
    }
}