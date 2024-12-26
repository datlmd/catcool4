<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Libraries\CI4Smarty;
use App\Libraries\Breadcrumb;
use Exception;
use App\Libraries\ReCaptcha;
use App\Libraries\Fba;
use App\Libraries\Google;
use App\Libraries\Facebook;
use App\Libraries\ZaloApi;
use App\Libraries\Robot;
use App\Libraries\Currency;
use App\Libraries\Customer;
use App\Libraries\React;
use App\Libraries\User;
use App\Libraries\Startup;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function smartyEngine($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('smartyEngine') : new CI4Smarty());
    }

    public static function breadcrumb($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('breadcrumb') : new Breadcrumb());
    }

    public static function reCaptcha2($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance(__FUNCTION__);
        }

        $config = config(ReCaptcha2::class);

        if (!$config)
        {
            throw new Exception(ReCaptcha2::class . ' not found.');
        }

        if (!$config->secret)
        {
            throw new Exception('The secret parameter is missing.');
        }

        $return = new ReCaptcha($config->secret);

        if ($config->expectedHostname !== null)
        {
            $return->setExpectedHostname($config->expectedHostname);
        }

        if ($config->challengeTimeout !== null)
        {
            $return->setChallengeTimeout($config->challengeTimeout);
        }

        return $return;
    }

    public static function reCaptcha3($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance(__FUNCTION__);
        }

        $config = config(ReCaptcha3::class);

        if (!$config)
        {
            throw new Exception(ReCaptcha3::class . ' not found.');
        }

        if (!$config->secret)
        {
            throw new Exception('The secret parameter is missing.');
        }

        $return = new ReCaptcha($config->secret);

        if ($config->scoreThreshold !== null)
        {
            $return->setScoreThreshold($config->scoreThreshold);
        }

        if ($config->expectedHostname !== null)
        {
            $return->setExpectedHostname($config->expectedHostname);
        }

        if ($config->challengeTimeout !== null)
        {
            $return->setChallengeTimeout($config->challengeTimeout);
        }

        return $return;
    }

    public static function fba($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('fba') : new Fba());
    }

    public static function google($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('google') : new Google());
    }

    public static function facebook($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('facebook') : new Facebook());
    }

    public static function zaloApi($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('zaloApi') : new ZaloApi());
    }

    public static function robot($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('robot') : new Robot());
    }

    public static function currency($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('currency') : new Currency());
    }

    public static function customer($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('customer') : new Customer());
    }

    public static function user($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('user') : new User());
    }

    public static function startup($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('startup') : new Startup());
    }

    public static function language(string $locale = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('language', $locale)->setLocale($locale);
        }

        // Use '?:' for empty string check
        $locale = $locale ?: \Config\Services::request()->getLocale();

        return new \App\Libraries\Language($locale);
    }

    public static function react($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('react') : new React());
    }

    public static function inertia($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('inertia');
        }

        return new \Inertia\Factory;
    }
}
