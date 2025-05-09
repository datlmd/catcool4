<?php

namespace App\Libraries;

// Include the autoloader provided in the SDK
require_once ROOTPATH . 'vendor/autoload.php';

use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class ZaloApi
{
    private $_zalo;
    private $_helper;

    public function __construct()
    {
        if (!isset($this->_zalo)) {
            $this->_zalo = new Zalo([
                'app_id'       => config_item('zalo_app_id'),
                'app_secret'   => config_item('zalo_app_secret'),
                'callback_url' => config_item('zalo_login_redirect_url'),
            ]);
        }

        $this->_helper = $this->_zalo->getRedirectLoginHelper();

        if (!empty(config_item('zalo_auth_on_load'))) {
            // Try and authenticate the user right away (get valid access token)
            $this->isAuthenticated();
        }
    }

    public function object()
    {
        return $this->_zalo;
    }

    public function isAuthenticated()
    {
        $callBackUrl = config_item('zalo_login_redirect_url');
        $oauthCode   = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
        $accessToken = $this->_helper->getAccessToken($callBackUrl); // get access token
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt(); // get expires time
            return $accessToken;
        }

        return false;
    }

    public function getUser($access_token = null, $params = ['fields' => 'id,name,birthday,gender,phone,picture'])
    {
        try {
            $response = $this->_zalo->get(ZaloEndpoint::API_GRAPH_ME, $access_token, $params);
            return $response->getDecodedBody();
        } catch (\Zalo\Exceptions\ZaloResponseException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        } catch (\Zalo\Exceptions\ZaloSDKException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    public function loginUrl()
    {
        // Login type must be web, else return empty string
        if (config_item('zalo_login_type') != 'web') {
            return '';
        }

        // Get login url
        return $this->_helper->getLoginUrl(config_item('zalo_login_redirect_url'));
    }

    private function logError($code, $message)
    {
        log_message('error', '[ZALO PHP SDK] code: ' . $code.' | message: '.$message);
        return ['error' => $code, 'message' => $message];
    }
}
