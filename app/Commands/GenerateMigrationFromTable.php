<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

/**
 * php spark make:migration-from-table address.
 */
class GenerateMigrationFromTable extends BaseCommand
{
    protected $group = 'Custom';
    protected $name = 'make:migration-from-table';
    protected $description = 'Tạo file migration từ bảng đã có trong database';

    public function run(array $params)
    {
        $table = $params[0] ?? null;
        if (!$table) {
            CLI::error('Vui lòng nhập tên bảng. Ví dụ: php spark make:migration-from-table users');

            return;
        }

        $db = Database::connect();

        $fields = $db->query('DESCRIBE `'.$db->prefixTable($table).'`')->getResultArray();

        $className = 'Create'.ucfirst($table).'Table';
        $fileName = date('Y_m_d_His').'_'.$className.'.php';
        $path = APPPATH.'Database/Migrations/'.$fileName;

        $schema = '';

        foreach ($fields as $field) {
            $type = strtoupper($field['Type']);
            $null = ($field['Null'] === 'YES') ? 'true' : 'false';
            $extra = $field['Extra'] ? "'{$field['Extra']}'" : "''";
            $schema .= "\t\t\t'{$field['Field']}' => [\n'type' => '{$type}',\n'null' => {$null}\n],\n";
        }

        $template = <<<EOT
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class {$className} extends Migration
{
    public function up()
    {
        \$this->forge->addField([
{$schema}\t\t]);

        \$this->forge->createTable('{$table}');
    }

    public function down()
    {
        \$this->forge->dropTable('{$table}');
    }
}
EOT;

        file_put_contents($path, $template);
        CLI::write('✅ Migration file created: '.$path, 'green');
    }
}
