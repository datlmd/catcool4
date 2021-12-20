<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [
//			[
//				'lang_key'   => 'heading_title',
//				'lang_value' => 'Backup &amp; Restore',
//				'lang_id'    => 1, // viet nam
//				'module_id'  => 30,
//				'user_id'	 => 1, //admin
//				'published'  => 1,
//			],
//			[
//				'lang_key'   => 'heading_title',
//				'lang_value' => 'Backup &amp; Restore',
//				'lang_id'    => 2, // tieng anh
//				'module_id'  => 30,
//				'user_id'	 => 1, //admin
//				'published'  => 1,
//			],

		];

		$model = model('App\Modules\Translations\Models\TranslationModel');

		if (!empty($data)) {
			$model->transStart();
			foreach ($data as $item) {
				$model->insert($item);
			}
			$model->transComplete();
		}
	}
}
