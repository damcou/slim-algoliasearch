<?php

namespace Tests\Functional\Api;

use \Tests\Functional\BaseTestCase;

class ApplicationTest extends BaseTestCase
{
    /**
     *  Wrong authorization token
     */
    const WRONG_TOKEN  = '0a511fb712807f9c61da9165b6c4d878d7af0392';

    /**
     * Test Adding Application
     */
    public function testApplicationEndpoints()
    {
        // Test POST Endpoint with wrong method
        $response = $this->runApp('GET', '/api/1/apps', $this->getSampleApplication());
        $this->assertEquals(405, $response->getStatusCode());

        // Test POST Endpoint without authorization
        $response = $this->runApp('POST', '/api/1/apps', $this->getSampleApplication());
        $this->assertEquals(403, $response->getStatusCode());

        // Test POST Endpoint with wrong token
        $response = $this->runApp('POST', '/api/1/apps', $this->getSampleApplication(), self::WRONG_TOKEN);
        $this->assertEquals(403, $response->getStatusCode());

        // Test POST Endpoint with good token
        $settings = \App\Helper\Config::getSettings();
        $token    = $settings['admin_account']['auth_token'];
        $response = $this->runApp('POST', '/api/1/apps', $this->getSampleApplication(), $token);
        $this->assertEquals(200, $response->getStatusCode());
        $result = json_decode($response->getBody(), true);

        // Then test DELETE Endpoint with wrong method
        $response = $this->runApp('POST', '/api/1/apps/'. $result['objectID']);
        $this->assertEquals(405, $response->getStatusCode());

        // Then test DELETE Endpoint without authorization
        $response = $this->runApp('DELETE', '/api/1/apps/'. $result['objectID']);
        $this->assertEquals(403, $response->getStatusCode());

        // Test DELETE Endpoint with wrong token
        $response = $this->runApp('DELETE', '/api/1/apps/'. $result['objectID'], null, self::WRONG_TOKEN);
        $this->assertEquals(403, $response->getStatusCode());

        // Test DELETE Endpoint with good token
        $response = $this->runApp('DELETE', '/api/1/apps/'. $result['objectID'], null, $token);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testApplicationDataIntegrity()
    {
        $settings = \App\Helper\Config::getSettings();
        $token    = $settings['admin_account']['auth_token'];

        // Test POST Endpoint with bad Application data (missing name)
        $response = $this->runApp('POST', '/api/1/apps', $this->getSampleApplicationWithMissingName(), $token);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(array_key_exists('errors', json_decode($response->getBody())));

        // Test POST Endpoint with bad Application data (non numeric rank)
        $response = $this->runApp('POST', '/api/1/apps', $this->getSampleApplicationWithNonNumericRank(), $token);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(array_key_exists('errors', json_decode($response->getBody())));
    }

    /**
     * Sample application data
     */
    protected function getSampleApplication()
    {
        return [
            'name'     => 'Damcou book',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  3
        ];
    }

    /**
     * Sample application data with missing name
     */
    protected function getSampleApplicationWithMissingName()
    {
        return [
            'name'     => '',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  3
        ];
    }

    /**
     * Sample application data with non numeric rank
     */
    protected function getSampleApplicationWithNonNumericRank()
    {
        return [
            'name'     => 'Damcou book',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  'abc'
        ];
    }
}
