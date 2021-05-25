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
	// public static function example($getShared = true)
	// {
	//     if ($getShared)
	//     {
	//         return static::getSharedInstance('example');
	//     }
	//
	//     return new \CodeIgniter\Example();
	// }

    public static function SmartyEngine($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('SmartyEngine') : new CI4Smarty());
    }

    public static function Breadcrumb($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('Breadcrumb') : new Breadcrumb());
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
        return ($getShared === true ? static::getSharedInstance('Fba') : new Fba());
    }

    public static function google($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('Google') : new Google());
    }

    public static function facebook($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('Facebook') : new Facebook());
    }

    public static function zaloApi($getShared = true)
    {
        return ($getShared === true ? static::getSharedInstance('ZaloApi') : new ZaloApi());
    }
}
