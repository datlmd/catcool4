<?php namespace App\Libraries;

// Include the autoloader provided in the SDK
require_once ROOTPATH . 'vendor/autoload.php';

use Facebook\Facebook as FB;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Helpers\FacebookRedirectLoginHelper;

class Facebook
{
    /**
     * @var FB
     */
    private $_fb;

    /**
     * @var FacebookRedirectLoginHelper|FacebookJavaScriptHelper
     */
    private $_helper;

    public function __construct()
    {
        if (!isset($this->fb)) {
            $this->_fb = new FB([
                'app_id' => config_item('fb_app_id'),
                'app_secret' => config_item('fb_app_secret'),
                'default_graph_version' => config_item('fb_graph_version')
            ]);
        }

        // Load correct helper depending on login type
        // set in the config file
        switch (config_item('fb_login_type')) {
            case 'js':
                $this->_helper = $this->_fb->getJavaScriptHelper();
                break;
            case 'canvas':
                $this->_helper = $this->_fb->getCanvasHelper();
                break;
            case 'page_tab':
                $this->_helper = $this->_fb->getPageTabHelper();
                break;
            case 'web':
                $this->_helper = $this->_fb->getRedirectLoginHelper();
                break;
        }
        if (!empty(config_item('fb_auth_on_load'))) {
            // Try and authenticate the user right away (get valid access token)
            $this->authenticate();
        }
    }

    /**
     * @return FB
     */
    public function object()
    {
        return $this->_fb;
    }

    /**
     * Check whether the user is logged in.
     * by access token
     *
     * @return mixed|boolean
     */
    public function isAuthenticated()
    {
        $access_token = $this->authenticate();
        if(isset($access_token)) {
            return $access_token;
        }
        return false;
    }

    public function request($method, $endpoint, $access_token = null, $params = [])
    {
        try {
            $response = $this->_fb->{strtolower($method)}($endpoint, $access_token);
            return $response->getDecodedBody();
        } catch (FacebookResponseException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        } catch (FacebookSDKException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    public function getUserInfor($user_id, $access_token)
    {
        try {
            $response = $this->_fb->get(
                "/$user_id",
                $access_token
            );
            return $response->getGraphNode();
        } catch (FacebookResponseException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        } catch (FacebookSDKException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Generate Facebook login url for web
     *
     * @return  string
     */
    public function loginUrl()
    {
        // Login type must be web, else return empty string
        if (config_item('fb_login_type') != 'web') {
            return '';
        }
        // Get login url
        return $this->_helper->getLoginUrl(
            config_item('fb_login_redirect_url'),
            config_item('fb_permissions')
        );
    }

    /**
     * Generate Facebook logout url for web
     *
     * @return string
     */
    public function logoutUrl()
    {
        // Login type must be web, else return empty string
        if (config_item('fb_login_type') != 'web') {
            return '';
        }
        // Get logout url
        return $this->_helper->getLogoutUrl(
            $this->getAccessToken(),
            config_item('fb_logout_redirect_url')
        );
    }

    /**
     * Destroy local Facebook session
     */
    public function destroySession()
    {
        session()->remove('fb_access_token');
    }

    /**
     * Get a new access token from Facebook
     *
     * @return array|AccessToken|null|object|void
     */
    private function authenticate()
    {
        $access_token = $this->getAccessToken();
        if ($access_token && $this->getExpireTime() > (time() + 30) || $access_token && !$this->getExpireTime()) {
            $this->_fb->setDefaultAccessToken($access_token);
            return $access_token;
        }
        // If we did not have a stored access token or if it has expired, try get a new access token
        if (!$access_token) {
            try {
                $access_token = $this->_helper->getAccessToken();
            } catch (FacebookSDKException $e) {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }
            // If we got a session we need to exchange it for a long lived session.
            if (isset($access_token)) {
                $access_token = $this->longLivedToken($access_token);
                $this->setExpireTime($access_token->getExpiresAt());
                $this->setAccessToken($access_token);
                $this->_fb->setDefaultAccessToken($access_token);
                return $access_token;
            }
        }
        // Collect errors if any when using web redirect based login
        if (config_item('fb_login_type') === 'web') {
            if($this->_helper->getError()) {
                // Collect error data
                $error = [
                    'error'             => $this->_helper->getError(),
                    'error_code'        => $this->_helper->getErrorCode(),
                    'error_reason'      => $this->_helper->getErrorReason(),
                    'error_description' => $this->_helper->getErrorDescription()
                ];
                return $error;
            }
        }
        return $access_token;
    }

    /**
     * Exchange short lived token for a long lived token
     *
     * @param AccessToken $access_token
     *
     * @return AccessToken|null
     */
    private function longLivedToken(AccessToken $access_token)
    {
        if (!$access_token->isLongLived()) {
            $oauth2_client = $this->_fb->getOAuth2Client();
            try {
                return $oauth2_client->getLongLivedAccessToken($access_token);
            } catch (FacebookSDKException $e) {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }
        }
        return $access_token;
    }

    /**
     * Get stored access token
     *
     * @return mixed
     */
    private function getAccessToken()
    {
        return session('fb_access_token');
    }

    /**
     * Store access token
     *
     * @param AccessToken $access_token
     */
    private function setAccessToken(AccessToken $access_token)
    {
        session()->set('fb_access_token', $access_token->getValue());
    }

    /**
     * @return mixed
     */
    private function getExpireTime()
    {
        return session('fb_expire');
    }

    /**
     * @param DateTime $time
     */
    private function setExpireTime(\DateTime $time = null)
    {
        if ($time) {
            session()->set('fb_expire', $time->getTimestamp());
        }
    }

    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    private function logError($code, $message)
    {
        log_message('error', '[FACEBOOK PHP SDK] code: ' . $code.' | message: '.$message);
        return ['error' => $code, 'message' => $message];
    }
}
