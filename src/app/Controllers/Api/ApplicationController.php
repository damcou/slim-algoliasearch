<?php

namespace App\Controllers\Api;

use \Psr\Container\ContainerInterface;
use \Slim\Http\Response;
use \Slim\Http\Request;
use \App\Helper\Algolia;

class ApplicationController
{
    /**
     * @var Algolia
     */
    protected $algoliaHelper;

    /**
     * HomeController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->algoliaHelper = new Algolia();
    }

    /**
     * Add application
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addApplication($request, $response, $args)
    {
        $data   = $request->getParsedBody();
        $result = $this->algoliaHelper->addApp($data);

        return $response->withJson(
            [
                "objectID" => $result['objectID']
            ]
        );
    }

    /**
     * Delete application
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function deleteApplication($request, $response, $args)
    {
        if (! isset($args['id'])) {
            return $response->withJson([]);
        }

        $applicationId = (int) $args['id'];
        $this->algoliaHelper->deleteApp($applicationId);

        return $response->withJson(
            [
                "status"   => $response->getStatusCode()
            ]
        );
    }
}
