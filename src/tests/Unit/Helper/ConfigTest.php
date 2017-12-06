<?php

namespace Tests\Unit;

use \App\Helper\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Config::getSettings
     */
    public function testGetSettings()
    {
        $settings = Config::getSettings();

        $this->assertArrayHasKey('apiVersions',$settings);
        $this->assertArrayHasKey('renderer',$settings);
        $this->assertArrayHasKey('algolia',$settings);
        $this->assertArrayHasKey('admin_account',$settings);
    }
}
