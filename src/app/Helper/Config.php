<?php

namespace App\Helper;

class Config
{
    /**
     * Get slim + custom config
     *
     * @return array
     */
    static public function getSettings()
    {
        return [
            'displayErrorDetails' => true, // set to false in production
            'addContentLengthHeader' => false, // Allow the web server to send the content-length header

            // Renderer settings
            'renderer' => [
                'template_path' => __DIR__ . '/../../templates/',
            ],
            // Algolia settings
            'algolia' => [
                'app_id'       => '53ITHX8IH4',
                'api_key'      => 'bd72a5e144d53b9a20039becab2638f8',
                'index_name'   => 'appstore',
                'replica_name' => 'appstore_rank_asc'
            ],
            // Admin account
            'admin_account' => [
                'login'      => 'admin',
                'password'   => '15f0f0f427b7a1c7c54051234900fdc4',
                'auth_token' => 'd79e2fea30698d727d3fa3239a7c1a644065dd62'
            ]
        ];
    }
}
