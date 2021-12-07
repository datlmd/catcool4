<?php namespace App\Controllers;

class Install extends BaseController
{

	public function index()
	{
		helper(['filesystem', 'number', 'catcool']);

		$file_permissions = [
			'writable',
			'writable/cache',
			'writable/html',
		];

		if (!is_dir(WRITEPATH . 'cache/html')) {

			//mkdir(WRITEPATH . 'cache/html', 0777, TRUE);
		}

		return view('install');
	}
}
