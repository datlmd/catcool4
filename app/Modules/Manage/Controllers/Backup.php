<?php

namespace App\Modules\Manage\Controllers;

use App\Controllers\AdminController;
use App\Modules\Manage\Models\BackupModel;

class Backup extends AdminController
{
    protected $errors = [];

    public const MANAGE_ROOT = 'manage/backup';
    public const MANAGE_URL  = 'manage/backup';

    protected $model;
    protected $db;

    protected $backup_path;

    public const FILE_PAGE_LIMIT = 30;

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');


        $this->model = new BackupModel();
        $this->db = db_connect();

        $this->backup_path = WRITEPATH . "database/backup/";

        helper('filesystem');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);
    }

    public function index()
    {
        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Backup.heading_title'), site_url(self::MANAGE_URL));

        $tables = $this->model->getTables();

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'tables' => $tables,
            'config_file_max_size' => $this->convertBytes(ini_get('upload_max_filesize')),
        ];

        add_meta(['title' => lang('Backup.heading_title')], $this->themes);

        $this->themes::load('backup/index', $data);
    }

    public function export()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $json = [];

        if (empty($this->request->getPost()) || empty($this->request->getGet())) {
            $json['error'] = lang('Admin.error_json');
        }

        $backup = $this->request->getPost('backup');
        $table  = $this->request->getGet('table');


        $filename = date('Y-m-d H.i.s') . '.sql';
        if (!empty($this->request->getGet('filename'))) {
            $filename = basename(html_entity_decode($this->request->getGet('filename'), ENT_QUOTES, 'UTF-8'));
        }

        if (!empty($this->request->getGet('page'))) {
            $page = (int)$this->request->getGet('page');
        } else {
            $page = 1;
        }

        $table_list = $this->model->getTables();
        if (!in_array($table, $table_list)) {
            $json['error'] = sprintf(lang('Backup.error_table'), $table);
        }

        if (!$json) {
            $output = '';

            if ($page == 1) {
                if (in_array($table . "_lang", $table_list)) {
                    $output .= 'DELETE FROM `' . $this->db->escapeString($table) . '`;' . "\n";
                    $output .= 'ALTER TABLE `' . $this->db->escapeString($table) .  '` AUTO_INCREMENT = 1;' . "\n\n";
                } else {
                    $output .= 'TRUNCATE TABLE `' . $this->db->escapeString($table) . '`;' . "\n\n";
                }
            }

            $record_total = $this->model->getTotalRecords($table);

            $results = $this->model->getRecords($table, ($page - 1) * 200, 200);

            foreach ($results as $result) {
                $fields = '';

                foreach (array_keys($result) as $value) {
                    $fields .= '`' . $value . '`, ';
                }

                $values = '';

                foreach (array_values($result) as $value) {
                    $value = str_replace(["\x00", "\x0a", "\x0d", "\x1a"], ['\0', '\n', '\r', '\Z'], $value);
                    $value = str_replace(["\n", "\r", "\t"], ['\n', '\r', '\t'], $value);
                    $value = str_replace('\\', '\\\\', $value);
                    $value = str_replace('\'', '\\\'', $value);
                    $value = str_replace('\\\n', '\n', $value);
                    $value = str_replace('\\\r', '\r', $value);
                    $value = str_replace('\\\t', '\t', $value);

                    $values .= '\'' . $value . '\', ';
                }

                $values = str_ireplace('\'\'', 'NULL', $values);

                $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
            }

            $position = array_search($table, $backup);

            if (($page * 200) >= $record_total) {
                $output .= "\n";

                if (isset($backup[$position + 1])) {
                    $table = $backup[$position + 1];
                } else {
                    $table = '';
                }
            }

            if ($position !== false) {
                $json['progress'] = round(($position / count($backup)) * 100);
            } else {
                $json['progress'] = 0;
            }

            if (!is_dir($this->backup_path)) {
                mkdir($this->backup_path, 0777, true);
            }

            $handle = fopen($this->backup_path . $filename, 'a');

            fwrite($handle, $output);

            fclose($handle);

            if (!$table) {
                $json['success'] = lang('Backup.text_success');
            } elseif (($page * 200) >= $record_total) {
                $json['text'] = sprintf(lang('Backup.text_backup'), $table, ($page - 1) * 200, $record_total);

                $json['next'] = str_replace('&amp;', '&', site_url() . 'manage/backup/export?filename=' . urlencode($filename) . '&table=' . $table . '&page=1');
            } else {
                $json['text'] = sprintf(lang('Backup.text_backup'), $table, ($page - 1) * 200, $page * 200);

                $json['next'] = str_replace('&amp;', '&', site_url() . 'manage/backup/export?filename=' . urlencode($filename) . '&table=' . $table . '&page=' . ($page + 1));
            }
        }

        $json['token'] = csrf_hash();

        json_output($json);
    }

    public function history()
    {
        helper('number');

        $page = $this->request->getGet('page');
        if (!empty($page)) {
            $page = $page;
        } else {
            $page = 1;
        }

        $directory = $this->backup_path;
        $files = glob($directory . '/*.sql', GLOB_BRACE);

        krsort($files);

        $list = [];
        foreach ($files as $value) {
            $key = str_ireplace("$this->backup_path/", '', $value);

            $file = [
                'name'       => $key,
                'permission' => octal_permissions(fileperms($value)),
                'size'       => number_to_size(filesize($value)),
                "modify"     => date('Y-m-d h:i:s', filemtime($value)),
                'download'   => site_url(self::MANAGE_URL) . '/download?filename=' . urlencode(basename($key)),
            ];

            $list[$key] = $file;
        }

        $sort_arr = array_column($list, 'modify');
        array_multisort($sort_arr, SORT_DESC, $list);

        $count_list = count($list);

        $list = array_splice($list, ($page - 1) * self::FILE_PAGE_LIMIT, self::FILE_PAGE_LIMIT);

        $config['base_url']   = site_url('manage/backup/history');
        $config['total_rows'] = $count_list;
        $config['per_page']   = self::FILE_PAGE_LIMIT;
        $config['page']       = $page;

        $data = [
            'list'   => $list,
            'pagination' => $this->_pagination($config),
        ];

        $token = csrf_hash();

        json_output(['token' => $token, 'data' => $this->themes::view('backup/history', $data)]);
    }

    private function _pagination($data)
    {
        $base_url = $data['base_url'];
        $total    = $data['total_rows'];
        $per_page = $data['per_page'];
        $page     = $data['page'];
        $pages    = intval($total / $per_page);

        if ($total % $per_page != 0) {
            $pages++;
        }

        $p        = "";
        if ($pages > 1) {
            for ($i = 1; $i <= $pages; $i++) {
                $p .= ($page == $i) ? '<li class="page-item active">' : '<li class="page-item">';
                $p .= '<a class="page-link directory" href="' . $base_url . '?page=' . $i . '" >' . $i . '</a></li>';
            }
        }

        return $p;
    }

    public function restore(): void
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $json = [];

        if (!empty($this->request->getGet('filename'))) {
            $filename = basename(html_entity_decode($this->request->getGet('filename'), ENT_QUOTES, 'UTF-8'));
        } else {
            $filename = '';
        }

        if (!empty($this->request->getGet('position'))) {
            $position = (int)$this->request->getGet('position');
        } else {
            $position = 0;
        }

        $file = $this->backup_path . $filename;

        if (!is_file($file)) {
            $json['error'] = lang('Backup.error_file');
        }

        if (!$json) {
            // We set $i so we can batch execute the queries rather than do them all at once.
            $i = 0;
            $start = false;

            $handle = fopen($file, 'r');

            fseek($handle, $position, SEEK_SET);

            while (!feof($handle) && ($i < 100)) {
                $position = ftell($handle);

                $line = fgets($handle, 1000000);

                //if (substr($line, 0, 14) == 'TRUNCATE TABLE' || substr($line, 0, 11) == 'INSERT INTO') {
                if (strpos(strtolower($line), 'truncate table') !== false
                    || strpos(strtolower($line), 'insert into') !== false
                    || strpos(strtolower($line), 'delete from') !== false
                    || strpos(strtolower($line), 'auto_increment = 1') !== false
                ) {
                    $sql = '';

                    $start = true;
                }

                if ($i > 0 && (
                    strpos(strtolower($line), 'user_admin') !== false
                        || strpos(strtolower($line), 'sessions') !== false
                )
                ) {
                    fseek($handle, $position, SEEK_SET);

                    break;
                }

                if ($start) {
                    $sql .= $line;
                }

                if ($start && substr($line, -2) == ";\n") {
                    try {
                        $this->db->query(substr($sql, 0, strlen($sql) - 2));
                    } catch (\Exception $ex) {
                        log_message('error', $sql);
                        log_message('error', $ex->getMessage());
                    }

                    $start = false;
                }

                $i++;
            }

            $position = ftell($handle);

            $size = filesize($file);

            if ($position) {
                $json['progress'] = round(($position / $size) * 100);
            } else {
                $json['progress'] = 0;
            }

            if ($position && !feof($handle)) {
                $json['text'] = sprintf(lang('Backup.text_restore'), $position, $size);
                $json['next'] = site_url() . 'manage/backup/restore?' . 'filename=' . urlencode($filename) . '&position=' . $position;
            } else {
                $json['success'] = lang('Backup.text_success');
            }

            fclose($handle);
        }

        $json['token'] = csrf_hash();

        json_output($json);
    }

    /**
     * Backup restore
     */
    public function restore_bk(): void
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $json = [];

        if (!empty($this->request->getGet('filename'))) {
            $filename = basename(html_entity_decode($this->request->getGet('filename'), ENT_QUOTES, 'UTF-8'));
        } else {
            $filename = '';
        }

        if (!empty($this->request->getGet('page'))) {
            $page = (int)$this->request->getGet('page');
        } else {
            $page = 1;
        }

        $file = $this->backup_path . $filename;

        if (!is_file($file)) {
            $json['error'] = lang('Backup.error_file');
        }

        $file_contents = file_get_contents($file);
        $file_contents = explode(";", $file_contents);

        $sql_contents = [];
        foreach ($file_contents as $value) {
            if (empty($value)
                || strpos(strtolower($value), 'user_admin') !== false
                || strpos(strtolower($value), 'sessions') !== false
            ) {
                continue;
            }

            if (strpos(strtolower($value), 'truncate table') !== false
                || strpos(strtolower($value), 'insert into') !== false
                || strpos(strtolower($value), 'delete from') !== false
                || strpos(strtolower($value), 'auto_increment = 1') !== false
            ) {
                $sql_contents[] = $value;
            }
        }

        if (empty($sql_contents)) {
            $json['error'] = lang('Backup.error_file');
        }

        if (!$json) {
            $limit = 200;

            $count_content = count($sql_contents);
            $sql_contents = array_splice($sql_contents, ($page - 1) * $limit, $limit);

            foreach ($sql_contents as $sql) {
                $this->db->query($sql);
            }

            $position = $page * $limit;
            if ($position) {
                $json['progress'] = round(($position / $count_content) * 100);
            } else {
                $json['progress'] = 0;
            }

            if ($page * $limit >= $count_content) {
                $json['success'] = lang('Backup.text_success');
            } else {
                $json['text'] = sprintf(lang('Backup.text_restore'), ($page - 1) * $limit, $count_content);

                $json['next'] = site_url() . 'manage/backup/restore?' . 'filename=' . urlencode($filename) . '&page=' . ($page + 1);
            }
        }

        $json['token'] = csrf_hash();

        json_output($json);
    }

    public function delete()
    {
        $token = csrf_hash();

        $filename = $this->request->getGet('filename');

        $is_super_admin = service('user')->getSuperAdmin();
        if (empty($is_super_admin)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_permission_execute')]);
        }

        if (!is_file($this->backup_path . $filename)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('FileManager.error_delete')]);
        }

        unlink($this->backup_path . $filename);

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('FileManager.text_delete') . " ($filename)"]);
    }

    public function download()
    {
        $filename = $this->request->getGet('filename');

        $file = $this->backup_path . $filename;

        if (!is_file($file)) {
            set_alert(sprintf(lang('Backup.error_not_found'), $filename), ALERT_ERROR, ALERT_POPUP);
            return redirect()->back();
        }

        if (!headers_sent()) {
            return $this->response->download($file, null);
        } else {
            set_alert(sprintf(lang('Backup.error_headers_sent'), $filename), ALERT_ERROR, ALERT_POPUP);
            return redirect()->back();
        }

    }

    public function upload()
    {
        try {

            $json = [];

            // create folder
            if (!is_dir($this->backup_path)) {
                mkdir($this->backup_path, 0777, true);
            }

            $file_name = 'upload';

            $file = $this->request->getFile($file_name);
            if (empty($file)) {
                $json['error'] = lang('FileManager.error_upload');
            }

            $config_file_max_size = $this->convertBytes(ini_get('upload_max_filesize'));
            if ($file->getSize() > $config_file_max_size) {
                $json['error'] = lang('Admin.error_upload_1');
            }

            if (!$json) {
                $filename = basename(html_entity_decode($file->getName(), ENT_QUOTES, 'UTF-8'));

                if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
                    $json['error'] = lang('FileManager.error_filename');
                }

                // Allowed file extension types
                if (strtolower(substr(strrchr($filename, '.'), 1)) != 'sql') {
                    $json['error'] = lang('FileManager.error_filetype');
                }
            }

            if (!$json) {
                move_uploaded_file($file->getRealPath(), $this->backup_path . $filename);
                $json['success'] = lang('FileManager.text_uploaded');
            }

        } catch (\Exception $ex) {
            $json['error'] = $ex->getMessage();
        }

        $json['token'] = csrf_hash();

        json_output($json);
    }

    private function convertBytes($value)
    {
        if (is_numeric($value)) {
            return $value;
        } else {
            $value_length = strlen($value);
            $qty = substr($value, 0, $value_length - 1);
            $unit = strtolower(substr($value, $value_length - 1));
            switch ($unit) {
                case 'k':
                    $qty *= 1024;
                    break;
                case 'm':
                    $qty *= 1048576;
                    break;
                case 'g':
                    $qty *= 1073741824;
                    break;
            }
            return $qty;
        }
    }
}
