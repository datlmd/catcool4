<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [

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
