<?php namespace App\Modules\Manage\Controllers;

use App\Controllers\AdminController;
use App\Modules\Manage\Models\BackupModel;

class Backup extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'manage/backup';
    CONST MANAGE_URL  = 'manage/backup';

    protected $model;
    protected $db;

    CONST FILE_PAGE_LIMIT = 3;

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');


        $this->model = new BackupModel();
        $this->db = db_connect();

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

        $token = csrf_hash();

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
                $output .= 'TRUNCATE TABLE `' . $this->db->escape($table) . '`;' . "\n\n";
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

            if (!is_dir(WRITEPATH . "database/backup")) {
                mkdir(WRITEPATH . "database/backup", 0777, true);
            }
            
            $handle = fopen(WRITEPATH . "database/backup/" . $filename, 'a');

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

        $json['token'] = $token;

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

        $directory = WRITEPATH . "database/backup";
        $files = glob($directory . '/*.sql', GLOB_BRACE);

        krsort($files);

        $list = [];
        foreach ($files as $value) {
            $key = str_ireplace(WRITEPATH . "database/backup/", '', $value);

            $file = [
                'name'       => $key,
                'permission' => octal_permissions(fileperms($value)),
                'size'       => number_to_size(filesize($value)),
                "modify"     => date('Y-m-d h:i:s', filemtime($value)),
            ];

            $list[$key] = $file;
        }

        $sort_arr = array_column($list, 'name');
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
            for ($i=1; $i<= $pages; $i++) {
                $p .= ($page == $i) ? '<li class="page-item active">' : '<li class="page-item">';
                $p .= '<a class="page-link directory" href="' . $base_url . '?page=' . $i . '" >' . $i . '</a></li>';
            }
        }

        return $p;
    }

    public function delete()
    {
        $token = csrf_hash();

        $filename = $this->request->getGet('f');

        $is_super_admin = session('admin.super_admin');
        if (empty($is_super_admin) || $is_super_admin !== TRUE) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_permission_execute')]);
        }

        if (!is_file(WRITEPATH . "database/backup/" . $filename)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('FileManager.error_delete')]);
        }

        unlink(WRITEPATH . "database/backup/" . $filename);

        json_output(['token' => $token, 'status' => 'ok', 'msg' => lang('FileManager.text_delete') . " ($filename)"]);
    }

}
