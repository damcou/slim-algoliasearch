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
     * Add application (API version 1)
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addApplicationV1($request, $response, $args)
    {
        $data   = $request->getParsedBody();
        $result = $this->algoliaHelper->addAppFromApi($data);

        if (isset($result['errors']) && count($result['errors']) > 0) {
            return $response->withJson(
                ['errors' => $result['errors']]
            );
        }

        return $response->withJson(['objectID' => $result['objectID']]);
    }

    /**
     * Delete application (API version 1)
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function deleteApplicationV1($request, $response, $args)
    {
        if (! isset($args['id']) || ! is_numeric($args['id']) ) {
            return $response->withJson(['error' => 'Application ID must be an int.']);
        }

        $this->algoliaHelper->deleteApp($args['id']);
        return $response->withJson(['status' => $response->getStatusCode()]);
    }
}
