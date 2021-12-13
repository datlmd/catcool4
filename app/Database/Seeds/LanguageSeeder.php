<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [

			[
				'lang_key'   => 'help_length_value',
				'lang_value' => 'Đặt thành 1.00000 nếu đây là kích thuớc mặc định của bạn',
				'lang_id'    => 1, // viet nam
				'module_id'  => 54, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'help_length_value',
				'lang_value' => 'Set to 1.00000 if this is your default length',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 54, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '54',
				'lang_id'    => 1, // viet nam
				'module_id'  => 54, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '54',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 54, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '53',
				'lang_id'    => 1, // viet nam
				'module_id'  => 54, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '53',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 54, // Admin
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
