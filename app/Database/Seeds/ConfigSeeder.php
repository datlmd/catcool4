<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigSeeder extends Seeder
{
	public function run()
	{
		/**
		 * Group
		 *
		 * 1 - General
		 * 2 - Page Setting
		 * 3 - Email Setting
		 * 4 - Image
		 * 5 - Servers
		 * 6 - Local
		 * 7 - Product
		 * 8 - Social
		 * 9 - Auth
		 *
		 */

		$data = [
//			[
//				'config_key'   => "day_clear_cache_auto",
//				'config_value' => "1,14,28",
//				'description'  => "Xóa cache html detail các ngày 1, 14 và ngày 28",
//				'group_id'	   => 5,
//				'published'    => 1,
//				'user_id'	   => 1,
//			],
		];

		$model = model('App\Modules\Configs\Models\ConfigModel');

		if (!empty($data)) {
			$model->transStart();
			foreach ($data as $item) {
				$model->insert($item);
			}
			$model->transComplete();
		}
	}
}
