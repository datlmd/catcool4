<?php namespace Config;

include_once WRITEPATH.'config/Config.php';

class Config extends CustomConfig
{
    /**
     * Minimum Required Length of Password (not enforced by lib - see note above)
     * @var int
     */
    public $minPasswordLength = 8;

    /**
     * The number of seconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.
     * @var int
     */
    public $forgotPasswordExpiration = 1800;
}

