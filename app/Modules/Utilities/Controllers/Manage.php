<?php namespace App\Modules\Utilities\Controllers;

use App\Controllers\AdminController;

class Manage extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'utilities/manage';
    CONST MANAGE_URL  = 'utilities/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
    }

    public function index()
    {
        $data = [];

        add_meta(['title' => lang("UtilityAdmin.heading_title")], $this->themes);
        theme_load('list', $data);
    }

    public function phpInfo()
    {
        $data['title'] = lang('UtilityAdmin.heading_title');
        $data['info_list'] = $this->_parsePhpInfo();

        $this->breadcrumb->add("PHP Info", site_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        theme_load('php_info', $data);
    }

    private function _parsePhpInfo()
    {
        ob_start(); phpinfo(INFO_MODULES); $s = ob_get_contents(); ob_end_clean();
        $s = strip_tags($s, '<h2><th><td>');
        $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', '<info>\1</info>', $s);
        $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', '<info>\1</info>', $s);
        $t = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
        $r = array(); $count = count($t);
        $p1 = '<info>([^<]+)<\/info>';
        $p2 = '/'.$p1.'\s*'.$p1.'\s*'.$p1.'/';
        $p3 = '/'.$p1.'\s*'.$p1.'/';
        for ($i = 1; $i < $count; $i++) {
            if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/', $t[$i], $matchs)) {
                $name = trim($matchs[1]);
                $vals = explode("\n", $t[$i + 1]);
                foreach ($vals AS $val) {
                    if (preg_match($p2, $val, $matchs)) { // 3cols
                        $r[$name][trim($matchs[1])] = array(trim($matchs[2]), trim($matchs[3]));
                    } elseif (preg_match($p3, $val, $matchs)) { // 2cols
                        $r[$name][trim($matchs[1])] = trim($matchs[2]);
                    }
                }
            }
        }
        return $r;
    }

    public function listFile()
    {
        $this->themes->addCSS('common/js/codemirror/lib/codemirror');
        $this->themes->addCSS('common/js/codemirror/theme/monokai');
        $this->themes->addCSS('common/js/fba/fba');

        $this->themes->addJS('common/js/codemirror/lib/codemirror');
        $this->themes->addJS('common/js/codemirror/lib/xml');
        $this->themes->addJS('common/js/fba/fba');

        $dir_list = ['media', 'app/Language', 'public/themes'];
        if (!empty($_GET['dir']) && in_array($_GET['dir'], $dir_list)) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'public/themes';
        }

        $data = [
            "api"      => "utilities/manage/load_fba?dir=" . urldecode($dir),
            "route"    => "utilities/manage/list_file?dir=" . urldecode($dir),
            "dir_list" => $dir_list,
            "dir"      => urldecode($dir),
        ];

        $this->breadcrumb->add("File Browser", site_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        $this->themes::load('list_file', $data);
    }

    public function loadFba()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $dir_list = ['media', 'app/Language', 'public/themes'];
        if (!empty($this->request->getGet('dir')) && in_array($this->request->getGet('dir'), $dir_list)) {
            $dir = $this->request->getGet('dir');
        } else {
            $dir = 'public/themes';
        }

        // Load class fba_lib.php
        $fba = service('fba');
        $fba->setPath($dir);

        // Scan direktori
        if(isset($_POST['path'])) {
            // Jalankan fungsi scan->('SUB DIR NAME')

            $res = $fba->scan($this->request->getPost('path'));
            json_output($res);
        } else if(!empty($this->request->getPost('file'))) { // Read file
            // Jalankan fungsi scan->('SUB DIR NAME')
            $res = $fba->read($this->request->getPost('file'));
            // Output isi file
            json_output($res);
        } else if(!empty($this->request->getPost('wfile')) && !empty($this->request->getPost('content'))) {
            $res = $fba->write($this->request->getPost('wfile'), $this->request->getPost('content'));
            // Output isi file
            json_output($res);
        }
    }
}
