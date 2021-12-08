<?php namespace App\Controllers;

class Install extends BaseController
{

	public function index()
	{
		helper(['filesystem', 'number', 'catcool']);

		$extension_info = [
			'database',
			'curl',
			'intl',
			'json',
			'mbstring',
			'xml',
			'gd',
			'gd2',
			'imagick',
			'mcrypt',
			'zlip',
			'zip'
		];

		$permission_info = [
			WRITEPATH 						=> 'writable',
			WRITEPATH . 'cache' 			=> 'writable/cache',
			WRITEPATH . 'cache/html' 		=> 'writable/cache/html',
			WRITEPATH . 'logs'			    => 'writable/logs',
			WRITEPATH . 'config'		    => 'writable/config',
			WRITEPATH . 'config/Config.php' => 'writable/config/Config.php',
			WRITEPATH . 'config/Routes.php' => 'writable/config/Routes.php',
			ROOTPATH . 'public/uploads' 	=> 'public/uploads',
			APPPATH . 'Modules' 			=> 'app/Modules',
			APPPATH . 'Language' 			=> 'app/Language',
			APPPATH . 'Language/vi' 		=> 'app/Language/vi',
			APPPATH . 'Language/en'	 		=> 'app/Language/en',
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
		foreach ($extension_info as $value) {
			$extension_list[$value] = (!extension_loaded($value)) ? 'OFF' : 'ON';
		}

		$data = [
			'permission_list' => $permission_list,
			'extension_list' => $extension_list,
		];

		return view('install', $data);
	}
}
