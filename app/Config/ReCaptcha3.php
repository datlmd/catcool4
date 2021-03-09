<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ReCaptcha3 extends BaseConfig
{

    public $key;

    public $secret;

    public $expectedHostname;

    public $scoreThreshold = 0.5;

    public $challengeTimeout;

}