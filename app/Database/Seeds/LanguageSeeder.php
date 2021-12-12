<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'lang_key'   => 'error_module',
				'lang_value' => 'Module không tồn tại',
				'lang_id'    => 1, // viet nam
				'module_id'  => 46, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_module',
				'lang_value' => 'Module does not exist!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 46, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'button_check',
				'lang_value' => 'Check',
				'lang_id'    => 1, // viet nam
				'module_id'  => 46, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'button_check',
				'lang_value' => 'Check',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 46, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			]
		];

		$model = model('App\Modules\Translations\Models\TranslationModel');

		$model->transStart();
		foreach ($data as $item) {
			$model->insert($item);
		}
		$model->transComplete();
	}
}
