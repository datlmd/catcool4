<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummySeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'lang_key'   => 'column_name',
				'lang_value' => 'Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'column_name',
				'lang_value' => 'Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'delete_heading',
				'lang_value' => 'Xoá Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'delete_heading',
				'lang_value' => 'Delete Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'heading_title',
				'lang_value' => 'Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'heading_title',
				'lang_value' => 'Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_add',
				'lang_value' => 'Tạo Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_add',
				'lang_value' => 'Add Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_edit',
				'lang_value' => 'Cập nhật Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_edit',
				'lang_value' => 'Edit Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_list',
				'lang_value' => 'Danh sách Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_list',
				'lang_value' => 'List Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_name',
				'lang_value' => 'Tên Dummy',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_name',
				'lang_value' => 'Tên Dummy',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '70',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_admin_id',
				'lang_value' => '70',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '70',
				'lang_id'    => 1, // viet nam
				'module_id'  => 70, // Admin
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'translate_frontend_id',
				'lang_value' => '70',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 70, // Admin
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
