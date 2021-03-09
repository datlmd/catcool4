<?php

namespace App\Libraries;

class ReCaptcha extends \App\Cells\ReCaptcha
{

    public function verify($response, $remoteIp = null)
    {
        if (!$remoteIp)
        {
            $ip = service('request')->getIPAddress();

            if ($ip && ($ip != '0.0.0.0'))
            {
                $remoteIp = $ip;
            }
        }

        return parent::verify($response, $remoteIp);
    }

}