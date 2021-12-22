<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'       => CSRF::class,
		'toolbar'    => DebugToolbar::class,
		'honeypot'   => Honeypot::class,
        'auth_admin' => \App\Filters\AuthAdminFilter::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			'csrf'       => [
			    'except' => [
                    'users/auth/recaptcha',
                    '*/manage/index',
                    'img/*',
                    'image/*',
                    'common/filemanager/*',
                    'countries/provinces',
                    'countries/districts',
                    'countries/wards',
                    'utilities/manage/load_fba',
                    'users/social_login',
					'*/manage/related',
					'manage/backup/upload',
                ]
            ],
            'auth_admin' => [
				'except' => [
					'*/login',
					'*/logout',
					'permissions/manage/not_allowed',
				]
			],
		],
		'after'  => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [];
}
