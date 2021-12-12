<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [

			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '56',
				'lang_id'    => 1, // viet nam
				'module_id'  => 56, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '56',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 56, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '55',
				'lang_id'    => 1, // viet nam
				'module_id'  => 56, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '55',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 56, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

		];

		$model = model('App\Modules\Translations\Models\TranslationModel');

		$model->transStart();
		foreach ($data as $item) {
			$model->insert($item);
		}
		$model->transComplete();
	}
}
