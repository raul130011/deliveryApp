<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model;
use ArrayObject;

final class JwtDecorator implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);

        $schemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'login' => [
                    'type' => 'string',
                    'example' => 'admin',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'admin',
                ],
            ],
        ]);

        $post = new Model\Operation(
            'postCredentialsItem',
            ['Token'],
            [
                '200' => [
                    'description' => 'Get JWT token',
                ],
                '400' => [
                    'description' => 'Bad request.',
                ],
                '401' => [
                    'description' => 'Invalid credentials.',
                ],
                '5XX' => [
                    'description' => 'Unexpected error.',
                ]
            ],
            'Get JWT token.',
            'Get the **Json Web Token** with **username** and **password** credentials.',
            null,
            [],
            new Model\RequestBody(
                'Generate new JWT Token',
                new ArrayObject([
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Credentials',
                        ],
                    ],
                ]),
            ),
        );

        $pathItem = new Model\PathItem(
            '2',
            '',
            '',
            null,
            null,
            $post,
            null,
            null,
            null,
            null,
            null
        );

        $openApi->getPaths()->addPath('/api/login_check', $pathItem);

        return $openApi;
    }
}