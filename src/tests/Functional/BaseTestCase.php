<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Process the application given a request method and URI
     *
     * @param string            $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string            $requestUri    the request URI
     * @param array|object|null $requestData   the request data
     * @param string|null       $authToken     authorization token
     *
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null, $authToken = null)
    {
        $envConfig = [
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri
        ];

        // Create a mock environment for testing with
        $environment = Environment::mock($envConfig);

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add an authorization coupon if specified
        if (! is_null($authToken)) {
            $request  = $request->withAddedHeader('AUTHORIZATION', $authToken);
        }

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Instantiate the application
        $app = new App(['settings' =>\App\Helper\Config::getSettings()]);

        // Set up dependencies
        require __DIR__ . '/../../slim/dependencies.php';

        // Register routes
        require __DIR__ . '/../../slim/router.php';

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }
}
