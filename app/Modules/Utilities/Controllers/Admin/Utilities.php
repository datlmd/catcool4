<?php

namespace App\Modules\Utilities\Controllers\Admin;

use App\Controllers\AdminController;

class Utilities extends AdminController
{
    protected $errors = [];

    public const MANAGE_ROOT = 'manage/utilities';
    public const MANAGE_URL  = 'manage/utilities';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

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

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');
        theme_load('list', $data);
    }

    public function phpInfo()
    {
        $data['title'] = lang('UtilityAdmin.heading_title');
        $data['info_list'] = $this->_parsePhpInfo();

        $this->breadcrumb->add(lang("UtilityAdmin.heading_title"), site_url(self::MANAGE_URL));
        $this->breadcrumb->add("PHP Info", site_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => "PHP Info"], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        theme_load('php_info', $data);
    }

    private function _parsePhpInfo()
    {
        ob_start();
        phpinfo(INFO_MODULES);
        $s = ob_get_contents();
        ob_end_clean();
        $s = strip_tags($s, '<h2><th><td>');
        $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', '<info>\1</info>', $s);
        $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', '<info>\1</info>', $s);
        $t = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
        $r = [];
        $count = count($t);
        $p1 = '<info>([^<]+)<\/info>';
        $p2 = '/'.$p1.'\s*'.$p1.'\s*'.$p1.'/';
        $p3 = '/'.$p1.'\s*'.$p1.'/';
        for ($i = 1; $i < $count; $i++) {
            if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/', $t[$i], $matchs)) {
                $name = trim($matchs[1]);
                $vals = explode("\n", $t[$i + 1]);
                foreach ($vals as $val) {
                    if (preg_match($p2, $val, $matchs)) { // 3cols
                        $r[$name][trim($matchs[1])] = [trim($matchs[2]), trim($matchs[3])];
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

        $dir_list = ['public/uploads', 'app/Language', 'public/themes'];
        if (!empty($_GET['dir']) && in_array($_GET['dir'], $dir_list)) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'public/themes';
        }

        $data = [
            "api"      => "manage/utility_load_fba?dir=" . urldecode($dir),
            "route"    => "manage/utility_load_fba?dir=" . urldecode($dir),
            "dir_list" => $dir_list,
            "dir"      => urldecode($dir),
        ];

        $this->breadcrumb->add(lang("UtilityAdmin.heading_title"), site_url(self::MANAGE_URL));
        $this->breadcrumb->add("File Browser", site_url(self::MANAGE_URL));
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang("File Browser")], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('list_file', $data);
    }

    public function loadFba()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $dir_list = ['public/uploads', 'app/Language', 'public/themes'];
        if (!empty($this->request->getGet('dir')) && in_array($this->request->getGet('dir'), $dir_list)) {
            $dir = $this->request->getGet('dir');
        } else {
            $dir = 'public/themes';
        }

        // Load class fba_lib.php
        $fba = service('fba');
        $fba->setPath($dir);

        // Scan direktori
        if (isset($_POST['path'])) {
            // Jalankan fungsi scan->('SUB DIR NAME')

            $res = $fba->scan($this->request->getPost('path'));
            json_output($res);
        } elseif (!empty($this->request->getPost('file'))) { // Read file
            // Jalankan fungsi scan->('SUB DIR NAME')
            $res = $fba->read($this->request->getPost('file'));
            // Output isi file
            json_output($res);
        } elseif (!empty($this->request->getPost('wfile')) && !empty($this->request->getPost('content'))) {
            $res = $fba->write($this->request->getPost('wfile'), $this->request->getPost('content'));
            // Output isi file
            json_output($res);
        }
    }

    public function logs()
    {
        helper(['filesystem', 'number']);

        $dir   = $this->request->getGet('dir');
        $name  = $this->request->getGet('name');
        $type  = $this->request->getGet('type');
        $sort  = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        $directory = WRITEPATH . "logs";
        if (!empty($dir) && is_dir($directory . "/$dir")) {
            $directory = $directory . "/$dir";
        }

        $files = glob($directory . '/*.log', GLOB_BRACE);

        krsort($files);

        $list = [];
        foreach ($files as $value) {
            $key = str_ireplace(WRITEPATH, '', $value);

            $file = [
                'name'       => $key,
                'permission' => octal_permissions(fileperms($value)),
                'size'       => number_to_size(filesize($value)),
                "modify"     => date('Y-m-d h:i:s', filemtime($value)),
            ];

            $list[$key] = $file;
        }

        //check delete & clear
        if ($type == 1 && !empty($list[$name])) {
            $is_super_admin = session('user_info.super_admin');
            if (empty($is_super_admin) || $is_super_admin !== true) {
                return redirect()->back();
            }

            if (is_file(WRITEPATH . $name)) {
                unlink(WRITEPATH . $name);
                set_alert(lang('FileManager.text_delete') . " ($name)", ALERT_SUCCESS);
            } else {
                set_alert(lang('FileManager.error_delete'), ALERT_ERROR);
            }
            return redirect()->back();
        } elseif ($type == 2) {
            $is_super_admin = session('user_info.super_admin');
            if (empty($is_super_admin) || $is_super_admin !== true) {
                return redirect()->back();
            }

            //clear
            foreach ($list as $value) {
                if (is_file(WRITEPATH . $value['name'])) {
                    unlink(WRITEPATH . $value['name']);
                }
            }
            set_alert(lang('FileManager.text_delete'), ALERT_SUCCESS, ALERT_POPUP);
            return redirect()->back();
        }

        $date_key = (empty($name) || empty($list[$name])) ? key($list) : $name;

        $sort = (empty($sort) || !in_array($sort, ['name', 'size', 'modify'])) ? 'name' : $sort;
        $sort_arr = array_column($list, $sort);
        if ($order == 'ASC') {
            array_multisort($sort_arr, SORT_ASC, $list);
        } else {
            array_multisort($sort_arr, SORT_DESC, $list);
        }

        $detail = [];
        if (!empty($list[$date_key])) {
            $detail = $list[$date_key];
            $detail['content'] = file_get_contents(WRITEPATH . $date_key);
        }

        foreach ($list as $key => $value) {
            $list[$key]['is_active'] =  ($value['name'] == $date_key) ? true : false;
        }

        $data = [
            'list'   => $list,
            'detail' => $detail,
            'dir'    => $dir,
            'sort'   => $sort,
            'order'  => ($order == 'ASC') ? 'DESC' : 'ASC',
        ];

        $this->breadcrumb->add(lang("UtilityAdmin.heading_title"), site_url(self::MANAGE_URL));
        $this->breadcrumb->add("Logs", site_url(self::MANAGE_URL) . 'logs');
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang("Logs")], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('logs', $data);
    }

    public function email()
    {
        $directory = APPPATH . "Views/email";
        $directory_admin = APPPATH . "Views/email/admin";

        $email_templates = glob($directory . '/*.tpl', GLOB_BRACE);
        $email_templates_admin = glob($directory_admin . '/*.tpl', GLOB_BRACE);

        $email_templates = array_merge($email_templates, $email_templates_admin);
        foreach ($email_templates as $key => $email_template) {
            $email_templates[$key] = str_ireplace([APPPATH . "Views/email/", ".tpl"], ["", ""], $email_template);
        }

        $template = $this->request->getPost('template') ?? "";
        $content = "";
        $subject = "";
        if ($this->request->getPost() && !empty($template)) {
            $subject_title = config_item('email_subject_title');
            $data_email = [];
            switch ($template) {
                case 'admin/forgot_password' || 'forgot_password':
                    $data_email = [
                        'full_name'               => sprintf('%s %s', "Dat", "Le"),
                        'username'                => 'UserTest',
                        'forgotten_password_code' => 'CodeTest',
                    ];
                    $subject = lang('Email.forgot_password_subject', ["UserTest"]);
                    break;
                case 'activate':
                    $data_email = [
                        'full_name'  => sprintf('%s %s', "Dat", "Le"),
                        'id'         => 9999,
                        'email'      => "email_test@gmail.com",
                        'activation' => "code_active",
                    ];
                    $subject = lang('Email.activation_subject');
                    break;
            }
            $content = $this->themes::view("email/$template", $data_email);

            $email = $this->request->getPost('email') ?? "";

            $this->validator->setRules([
                'email' => [lang('Email.text_email'), 'rules' => 'required|valid_email'],
                'template' => [lang("Email.text_template"), 'rules' => 'required']
            ]);

            if ($this->validator->withRequest($this->request)->run()) {
                $send_email = send_email($email, config_item('email_from'), $subject, $content, $subject_title);
                if (!$send_email) {
                    $data['errors'] = lang('Email.error_sent_unsuccessful');
                } else {
                    set_alert(lang('Email.text_sent_successful'), ALERT_SUCCESS);
                    ;
                }
            }

            if (isset($_POST['email']) && !empty($this->validator->getErrors())) {
                $data['errors'] = $this->validator->getErrors();
            }
        }

        $data['email_templates'] = $email_templates;
        $data['template']        = $template;
        $data['content']         = $content;
        $data['subject']         = $subject;

        $this->breadcrumb->add(lang("UtilityAdmin.heading_title"), site_url(self::MANAGE_URL));
        $this->breadcrumb->add(lang("Email.text_email"), site_url(self::MANAGE_URL) . 'email');
        $data['breadcrumb'] = $this->breadcrumb->render();

        add_meta(['title' => lang("Email.text_email")], $this->themes);
        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('email', $data);
    }
}
