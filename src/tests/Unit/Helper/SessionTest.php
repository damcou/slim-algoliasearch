<?php

namespace Tests\Unit;

use \App\Helper\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /** @var Session  */
    protected $sessionHelper;

    /**
     * SessionTest constructor.
     *
     **/
    public function __construct()
    {
        parent::__construct();
        $this->sessionHelper = new Session();
    }

    /**
     * @covers Session::check
     */
    public function testCheck()
    {
        $this->assertFalse($this->sessionHelper->check());
        $_SESSION['admin_session'] = true;
        $this->assertTrue($this->sessionHelper->check());
        unset($_SESSION['admin_session']);
        $this->assertFalse($this->sessionHelper->check());
    }

    /**
     * @covers Session::login
     */
    public function testGetSettings()
    {
        $this->assertFalse($this->sessionHelper->login('badUser','badPassword'));
    }

    /**
     * @covers Session::logout
     */
    public function testLogout()
    {
        $_SESSION['admin_session'] = true;
        $this->sessionHelper->logout();
        $this->assertArrayNotHasKey('admin_session', $_SESSION);
    }
}
