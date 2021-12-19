<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'lang_key'   => 'heading_title',
				'lang_value' => 'Backup &amp; Restore',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'heading_title',
				'lang_value' => 'Backup &amp; Restore',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_success',
				'lang_value' => 'Success: You have successfully modified your database!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_success',
				'lang_value' => 'Success: You have successfully modified your database!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_backup',
				'lang_value' => 'Backing up table %s records %s to %s records',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_backup',
				'lang_value' => 'Backing up table %s records %s to %s records',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_restore',
				'lang_value' => 'Restoring %s of %s',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_restore',
				'lang_value' => 'Restoring %s of %s',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_option',
				'lang_value' => 'Backup Options',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_option',
				'lang_value' => 'Backup Options',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_history',
				'lang_value' => 'Backup History',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_history',
				'lang_value' => 'Backup History',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_progress',
				'lang_value' => 'Progress',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_progress',
				'lang_value' => 'Progress',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'text_import',
				'lang_value' => 'For large backup files it is better to upload the SQL file via FTP to the <strong>~/storage/backup/</strong> directory.',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'text_import',
				'lang_value' => 'For large backup files it is better to upload the SQL file via FTP to the <strong>~/storage/backup/</strong> directory.',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'column_filename',
				'lang_value' => 'Filename',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'column_filename',
				'lang_value' => 'Filename',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'column_size',
				'lang_value' => 'Size',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'column_size',
				'lang_value' => 'Size',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'column_date_added',
				'lang_value' => 'Date Added',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'column_date_added',
				'lang_value' => 'Date Added',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'column_action',
				'lang_value' => 'Action',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'column_action',
				'lang_value' => 'Action',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'entry_progress',
				'lang_value' => 'Progress',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'entry_progress',
				'lang_value' => 'Progress',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'entry_export',
				'lang_value' => 'Export',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'entry_export',
				'lang_value' => 'Export',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_export',
				'lang_value' => 'Warning: You must select at least one table to export!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_export',
				'lang_value' => 'Warning: You must select at least one table to export!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_table',
				'lang_value' => 'Table %s is not in the allowed list!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_table',
				'lang_value' => 'Table %s is not in the allowed list!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_file',
				'lang_value' => 'File could not be found!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_file',
				'lang_value' => 'File could not be found!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_directory',
				'lang_value' => 'Directory could not be found!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_directory',
				'lang_value' => 'Directory could not be found!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_not_found',
				'lang_value' => 'Error: Could not find file %s !',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_not_found',
				'lang_value' => 'Error: Could not find file %s !',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],

			[
				'lang_key'   => 'error_headers_sent',
				'lang_value' => 'Error: Headers already sent out!',
				'lang_id'    => 1, // viet nam
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
			[
				'lang_key'   => 'error_headers_sent',
				'lang_value' => 'Error: Headers already sent out!',
				'lang_id'    => 2, // tieng anh
				'module_id'  => 30,
				'user_id'	 => 1, //admin
				'published'  => 1,
			],
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
