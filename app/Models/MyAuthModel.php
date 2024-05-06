<?php namespace App\Models;

class MyAuthModel extends MyModel
{
    /**
     * Max cookie lifetime constant
     */
    const MAX_COOKIE_LIFETIME = 63072000; // 2 years = 60*60*24*365*2 = 63072000 seconds;

    /**
     * Max password size constant
     */
    const MAX_PASSWORD_SIZE_BYTES = 4096;

    function __construct()
    {
        parent::__construct();

    }

    public function generateSelectorValidatorCouple($selector_size = 40, $validator_size = 128)
    {
        // The selector is a simple token to retrieve the user
        $selector = $this->_randomToken($selector_size);

        // The validator will strictly validate the user and should be more complex
        $validator = $this->_randomToken($validator_size);

        // The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
        $validator_hashed = $this->hashPassword($validator);

        // The code to be used user-side
        $user_code = "$selector.$validator";

        return [
            'selector' => $selector,
            'validator_hashed' => $validator_hashed,
            'user_code' => $user_code,
        ];
    }

    public function retrieveSelectorValidatorCouple($user_code)
    {
        // Check code
        if ($user_code)
        {
            $tokens = explode('.', $user_code);

            // Check tokens
            if (count($tokens) === 2) {
                return [
                    'selector' => $tokens[0],
                    'validator' => $tokens[1]
                ];
            }
        }

        return FALSE;
    }

    protected function _randomToken($result_length = 32)
    {
        if(!isset($result_length) || intval($result_length) <= 8 ){
            $result_length = 32;
        }

        // Try random_bytes: PHP 7
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($result_length / 2));
        }

        // Try mcrypt
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($result_length / 2, MCRYPT_DEV_URANDOM));
        }

        // Try openssl
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($result_length / 2));
        }

        // No luck!
        return FALSE;
    }

    public function hashPassword($password)
    {
        return password_hash(md5($password) . md5(config_item('catcool_hash')), PASSWORD_DEFAULT, ['cost' => 12]);
    }

    public function checkPassword($password, $password_db)
    {
        if (empty($password) || empty($password_db) || strpos($password, "\0") !== FALSE
            || strlen($password) > self::MAX_PASSWORD_SIZE_BYTES)
        {
            return FALSE;
        }

        return password_verify(md5($password) . md5(config_item('catcool_hash')), $password_db);
    }

    public function token(int $length = 40): string {
        return $this->_randomToken($length);
    }
}
