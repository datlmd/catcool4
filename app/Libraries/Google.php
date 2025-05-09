<?php

namespace App\Libraries;

// Include the autoloader provided in the SDK
require_once ROOTPATH . 'vendor/autoload.php';

use Google_Client;
use Google_Service_Oauth2;

class Google
{
    public function __construct()
    {

        $config = config('Config');

        $this->client = new Google_Client();
        $this->client->setApplicationName($config->googleApplicationName);
        $this->client->setClientId($config->googleClientId);
        $this->client->setClientSecret($config->googleClientSecret);
        $this->client->setRedirectUri($config->googleRedirectUri);
        $this->client->setDeveloperKey($config->googleApiKey);
        $this->client->setScopes($config->googleScopes);
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');

        $this->oauth2 = new Google_Service_Oauth2($this->client);
    }

    public function loginUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function getAuthenticate($code)
    {
        if (empty($code)) {
            return false;
        }

        return $this->client->authenticate($code);
    }

    public function getAccessToken()
    {
        return $this->client->getAccessToken();
    }

    public function setAccessToken()
    {
        return $this->client->setAccessToken();
    }

    /**
     * Reset OAuth access token
     *
     * @return bool
     */
    public function revokeToken()
    {
        return $this->client->revokeToken();
    }

    public function getUserInfo()
    {
        return $this->oauth2->userinfo->get();
    }
}
