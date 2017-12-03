<?php

namespace App\Controllers\Admin;

use \Psr\Container\ContainerInterface;
use \Slim\Http\Response;
use \Slim\Http\Request;
use \App\Helper\Session;

class LoginController extends AbstractController
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * LoginController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        parent::__construct($container);
        $this->session = new Session();
    }

    /**
     * Login form view
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signIn($request, $response, $args)
    {
        return $this->getView()->render($response, 'admin/views/signin.twig', $args);
    }

    /**
     * Log out
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signOut($request, $response, $args)
    {
        $this->session->logout();
        return $response->withRedirect('/admin/login');
    }

    /**
     * Handle login post
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function signInPost($request, $response, $args)
    {
        if (! $request->isPost()) {
            throw new \Exception('Invalid method');
        }

        $data = $request->getParsedBody();
        if (! $data['user'] || ! $data['password']) {
            $this->getFlash()->addMessage('error', 'Missing user or password' );
            return $response->withRedirect('/admin/login');
        }

        $attempt = $this->session->login($data['user'], $data['password']);

        if (! $attempt) {
            $this->getFlash()->addMessage('error', 'Wrong user or password' );
        }

        return $response->withRedirect('/admin/login');
    }
}
