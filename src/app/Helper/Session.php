<?php

namespace App\Helper;

class Session
{
    /**
     * Check if user is currently logged
     *
     * @return boolean
     */
    public function check()
    {
        return isset($_SESSION['admin_session']);
    }

    /**
     * Try to log user
     *
     * @param string $account
     * @param string $password
     *
     * @return boolean
     */
    public function login($account, $password)
    {
        $settings      = Config::getSettings();
        $adminSettings = $settings['admin_account'];

        if ($account == $adminSettings['login'] && md5($password) == $adminSettings['password']) {
            $_SESSION['admin_session'] = true;
            return true;
        }

        return false;
    }

    /**
     * Log out the user
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['admin_session']);
    }
}