<?php

namespace App\Controllers\Admin;

use \Psr\Container\ContainerInterface;
use \Slim\Http\Response;
use \Slim\Http\Request;
use \App\Helper\Algolia;

class AdminController extends AbstractController
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
        parent::__construct($container);
        $this->algoliaHelper = new Algolia();
    }

    /**
     * Dashboard view
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dashboard($request, $response, $args)
    {
        return $this->getView()->render($response, 'admin/views/dashboard.twig', $args);
    }

    /**
     * Add application view
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add($request, $response, $args)
    {
        $args['index_categories'] = $this->algoliaHelper->getIndexCategories();
        return $this->getView()->render($response, 'admin/views/add.twig', $args);
    }

    /**
     * Delete application view
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($request, $response, $args)
    {
        return $this->getView()->render($response, 'admin/views/delete.twig', $args);
    }

    /**
     * Handle add application post
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function addPost($request, $response, $args)
    {
        if (! $request->isPost()) {
            throw new \Exception('Invalid method');
        }

        $data = $request->getParsedBody();
        $result = $this->algoliaHelper->addApp($data);

        if (isset($result['objectID'])) {
            $this->getFlash()->addMessage('info', 'Application (ID : ' . $result['objectID'] . ') has been added!' );
        }

        return $response->withRedirect('/admin/add');
    }

    /**
     * Handle delete application post
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function deleteAppPost($request, $response, $args)
    {
        if (! $request->isPost()) {
            throw new \Exception('Invalid method');
        }

        $data = $request->getParams();
        return $this->processAppDeletion($data['id'], $request, $response, $args);
    }

    /**
     * Application deletion
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteApp($request, $response, $args)
    {
        $appId = $request->getParam('app_id');
        return $this->processAppDeletion($appId, $request, $response, $args);
    }

    /**
     * Process application deletion
     *
     * @param string   $appId
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    protected function processAppDeletion($appId, $request, $response, $args)
    {
        $this->algoliaHelper->deleteApp($appId);

        $this->getFlash()->addMessage('info', 'Application ' . $appId . ' has been deleted!');
        return $response->withRedirect('/admin/delete');
    }

    /**
     * Search index categories
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function searchPost($request, $response, $args)
    {
        if (! $request->isPost()) {
            throw new \Exception('Invalid method');
        }

        $data = $request->getParams();
        $apps = $this->algoliaHelper->searchAppsByName($data['name']);

        if (count($apps) == 0) {
            $this->getFlash()->addMessage('error', 'No results found for : ' . $data['name']);
        }
        $args['apps'] = $apps;

        return $this->getView()->render($response, 'admin/views/delete.twig', $args);
    }
}
