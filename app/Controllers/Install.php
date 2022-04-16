<?php namespace App\Controllers;

class Install extends BaseController
{
	public function index()
	{
		helper(['filesystem', 'number', 'catcool']);

		$extension_info = [
			'curl' => 'ON',
			'intl' => 'ON',
			'json' => 'ON',
			'mbstring' => 'ON',
			'xml' => 'ON',
			'openssl' => 'ON',
			'iconv' => 'ON',
			'gd' => 'ON',
			'gd2' => 'ON',
			'imagick'  => 'ON',
			'mcrypt' => 'ON',
			'zlip' => 'ON',
			'zip' => 'ON',
		];

		$permission_info = [
			WRITEPATH 						       => 'writable',
			WRITEPATH . 'cache' 			       => 'writable/cache',
			WRITEPATH . 'cache/html' 		       => 'writable/cache/html',
            WRITEPATH . 'cache/smarty/cache'   	   => 'cache/smarty/cache',
            WRITEPATH . 'cache/smarty/templates_c' => 'cache/smarty/templates_c',
			WRITEPATH . 'logs'			           => 'writable/logs',
			WRITEPATH . 'config'		           => 'writable/config',
			WRITEPATH . 'config/Config.php'        => 'writable/config/Config.php',
			WRITEPATH . 'config/Routes.php'        => 'writable/config/Routes.php',
			ROOTPATH . 'public/uploads' 	       => 'public/uploads',
			APPPATH . 'Modules' 			       => 'app/Modules',
			APPPATH . 'Language' 			       => 'app/Language',
			APPPATH . 'Language/vi' 		       => 'app/Language/vi',
			APPPATH . 'Language/en'	 		       => 'app/Language/en',
		];

		$permission_list = [];
		foreach ($permission_info as $key => $value) {
			if (is_file($key) || is_dir($key)) {
				$permission_list[$key] = is_writable($key) ? "Writable" : octal_permissions(fileperms($key));
			} else {
				$permission_list[$key] = "File not found!";
			}
		}

		$extension_list = [];
		foreach ($extension_info as $key => $value) {
			$extension_list[$key]['required'] = $value;
			$extension_list[$key]['status'] = (!extension_loaded($key)) ? 'OFF' : 'ON';
		}

		$db = [
			'mysqli',
			'pgsql',
			'pdo'
		];

		if (!array_filter($db, 'extension_loaded')) {
			$extension_list['database']['required'] = 'ON';
			$extension_list['database']['status'] = 'OFF';
		} else {
			$extension_list['database']['required'] = 'ON';
			$extension_list['database']['status'] = 'ON';
		}

		$data = [
			'permission_list' => $permission_list,
			'extension_list' => $extension_list,
			'register_globals' => ini_get('register_globals'),
			'magic_quotes_gpc' => ini_get('magic_quotes_gpc'),
			'file_uploads' => ini_get('file_uploads'),
			'session_auto_start' => ini_get('session_auto_start'),
		];

		return view('install', $data);
	}
}
