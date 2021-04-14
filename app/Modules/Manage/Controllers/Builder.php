<?php namespace App\Modules\Manage\Controllers;

use App\Controllers\AdminController;

class Builder extends AdminController
{
    CONST MANAGE_ROOT = 'manage/builder';
    CONST MANAGE_URL  = 'manage/builder';

    private $db;
    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->db = \Config\Database::connect();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Builder.heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        helper('filesystem');
        $data = [];

        $error_created = [];

        $this->validator->setRule('module_name', sprintf(lang('Admin.text_manage_validation'), lang('Builder.module_name')), 'required');
        $this->validator->setRule('controller_name', sprintf(lang('Admin.text_manage_validation'), lang('Builder.controller_name')), 'required');
        $this->validator->setRule('model_name', sprintf(lang('Admin.text_manage_validation'), lang('Builder.model_name')), 'required');
        $this->validator->setRule('is_language', sprintf(lang('Admin.text_manage_validation'), "Language"), 'required');

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            if (!empty($this->request->getPost('is_language'))) {
                $data = $this->_addFormLanguage();
            } else {
                $data = $this->_addFormSingle();
            }
        }

        //check permissions
        $file_list = [];
        $folder_list= [
            'Modules',
            'Language/vi',
            'Language/en',
        ];
        foreach ($folder_list as $foler) {
            $file_list[$foler] = is_writable(APPPATH . $foler) ? "Writable" : "Not writable";
        }

        $data['file_list'] = $file_list;

        if (!empty($this->request->getGet('is_delete')) && !empty($this->request->getGet('module'))) {
            $this->_rrmdir(APPPATH . "Modules/" . ucfirst($this->request->getGet('module')));
        }

        add_meta(['title' => lang("Builder.heading_title")], $this->themes);
        $this->themes::load('builder', $data);
    }

    private function _addFormLanguage()
    {
        // get data from form
        $module_name     = strtolower($this->request->getPost('module_name'));
        $controller_name = strtolower($this->request->getPost('controller_name'));
        $model_name      = strtolower($this->request->getPost('model_name'));
        $table_name      = strtolower($this->request->getPost('table_name'));

        if (empty($module_name) || empty($controller_name) || empty($model_name)) {
            set_alert(lang('Amin.error'), ALERT_ERROR);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        //neu ten table khong tai thi su sung ten model lam table
        if (empty($table_name)) {
            $table_name = $model_name;
        }
        $table_name_language = $table_name . '_lang';

        if (!$this->db->tableExists($table_name) || !$this->db->tableExists($table_name_language)) {
            set_alert(sprintf(lang('error_table_not_found'), $table_name, $table_name_language), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if ($controller_name == "manage") {
            $controller_name = $module_name;
        }
        $module_name_class     = ucfirst($module_name);
        $controller_name_class = ucfirst($controller_name);
        $model_name_class      = ucfirst($model_name);
        $language_name_class   = ($module_name != $controller_name)? singular(ucfirst($module_name)) . singular(ucfirst($controller_name)) : singular(ucfirst($controller_name));

        // create module
        if (!is_dir(APPPATH . "Modules/" . $module_name_class)) {
            mkdir(APPPATH . 'Modules/' . $module_name_class, 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Config')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Config', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Controllers')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Controllers', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Models')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Models', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Views')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Views', 0777, true);
        }

        //write language
        $string_language_vn = file_get_contents(APPPATH . 'Language/vi/Dummy.php');
        $string_language_en = file_get_contents(APPPATH . 'Language/en/Dummy.php');

        $string_language_vn = str_replace('Dummy', $controller_name_class, $string_language_vn);
        $string_language_en = str_replace('Dummy', $controller_name_class, $string_language_en);

        if (!is_file(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php')) {
            write_file(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php', $string_language_vn);
            chmod(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), 'vi/' . $language_name_class . 'Admin.php');

        }

        if (!is_file(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php')) {
            write_file(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php', $string_language_en);
            chmod(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), 'en/' .  $language_name_class . 'Admin.php');
        }

        $manage_path = '';
        $manage_name_controller = $module_name . '/';
        // neu la controller con cua module
        if ($module_name != $controller_name) {
            $manage_path = $controller_name . '/';
            $manage_name_controller = $module_name . '/' . $controller_name . '_';

            if (!is_dir(APPPATH . 'Modules/'. $module_name_class . '/Views/' . $controller_name)) {
                mkdir(APPPATH . 'Modules/'. $module_name_class . '/Views/' . $controller_name, 0777, true);
            } else {
                $error_created[] = sprintf(lang('folder_created'), $controller_name );
            }
        }

        //template su dung cho tpl add va edit
        $template_field_root = "
                <div class=\"form-group\">
                    <label class=\"form-label\">{lang('%sAdmin.text_%s')}</label>
                    {if isset(\$edit_data.%s)}
                        {assign var=\"%s\" value=\"`\$edit_data.%s`\"}
                    {else}
                        {assign var=\"%s\" value=\"\"}
                    {/if}
                    <input type=\"text\" name=\"%s\" value=\"{old('%s', \$%s)}\" id=\"%s\" class=\"form-control\">
                </div>";
        $template_field_description = "
                <div class=\"form-group row\">
                    <label class=\"col-12 col-sm-3 col-form-label text-sm-end\">
                        {lang('%sAdmin.text_%s')}
                    </label>
                    <div class=\"col-12 col-sm-8 col-lg-7\">
                        {if !empty(\$edit_data.%s[\$language.id].%s)}
                            {assign var=\"%s\" value=\"`\$edit_data.%s[\$language.id].%s`\"}
                        {else}
                            {assign var=\"%s\" value=\"\"}
                        {/if}
                        <input type=\"text\" name=\"lang_{\$language.id}_%s\" value=\'{old(\"lang_`\$language.id`_%s\", \$%s)}\' id=\"input_%s_{\$language.id}\" class=\"form-control\">
                    </div>
                </div>";

        //template khi post data khi add va edit
        $template_add_post_root = "
                '%s' => \$this->request->getPost('%s'),";

        $template_replace_root        = ""; // : {*TPL_DUMMY_ROOT*}
        $template_replace_description = ""; // : {*TPL_DUMMY_DESCRIPTION*}
        $template_add_post_replace_root = ""; // : //ADD_DUMMY_ROOT

        $field_root = ""; // : //FIELD_ROOT
        $field_description = ""; // : //FIELD_DESCRIPTION

        $primary_key = "";

        // get data field root
        if ($this->db->tableExists($table_name) ) {
            $fields = $this->db->getFieldData($table_name);
            if (!empty($fields)) {
                $list_not_add = [$table_name . '_id', 'sort_order', 'published', 'user_id', 'ctime', 'mtime'];
                foreach ($fields as $field) {
                    if (!empty($field->primary_key)) {
                        $primary_key = $field->name;
                        continue;
                    }
                    if (in_array($field->name, $list_not_add)) {
                        continue;
                    }
                    $field_root .= '"' . $field->name . '",' . PHP_EOL;

                    //them field cho tpl add va edit
                    $template_replace_root .= sprintf(
                        $template_field_root,
                        $language_name_class,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                    );

                    //them field khi submit trong manage
                    $template_add_post_replace_root .= sprintf(
                        $template_add_post_root,
                        $field->name,
                        $field->name
                    );
                }
            }
        }
        // get data field description
        if ($this->db->tableExists($table_name_language) ) {
            $fields = $this->db->getFieldData($table_name_language);
            if (!empty($fields)) {
                $list_not_add = [$table_name . '_id', 'name', 'description', 'language_id'];
                foreach ($fields as $field) {
                    if (in_array($field->name, $list_not_add)) {
                        continue;
                    }
                    $field_description .= '"' . $field->name . '",' . PHP_EOL;

                    //them field cho tpl add va edit
                    $template_replace_description .= sprintf(
                        $template_field_description,
                        $language_name_class,
                        $field->name,
                        $table_name_language,
                        $field->name,
                        $field->name,
                        $table_name_language,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                    );
                }
            }
        }

        //write class controller
        $string_controller = file_get_contents(APPPATH . 'Modules/Dummy/Controllers/Manage.php');

        $string_controller_from = [
            "App\Modules\Dummy\Controllers",
            "App\Modules\Dummy\Models\DummyModel",
            "App\Modules\Dummy\Models\DummyLangModel",
            "class Manage extends",
            "dummy/manage", //MANAGE_ROOT & MANAGE_URL
            "new DummyModel()",
            "new DummyLangModel()",
            "lang('Dummy.", //language
            "'dummy'", //paging
            "manage/list",
            "manage/form",
            "manage/delete",
            "dummy_id",
            "//ADD_DUMMY_ROOT",
        ];

        $controller_name_class_tpm =  ($module_name != $controller_name) ? "class " . $controller_name_class . "Manage extends" : "class Manage extends";

        $string_controller_to = [
            "App\Modules\\" . $module_name_class . "\Controllers",
            "App\Modules\\" . $module_name_class . "\Models\\" . $model_name_class . "Model",
            "App\Modules\\" . $module_name_class . "\Models\\" . $model_name_class . "LangModel",
            $controller_name_class_tpm,
            $manage_name_controller . "manage",
            "new " . $model_name_class . "Model()",
            "new " . $model_name_class . "LangModel()",
            "lang('" . $language_name_class . "Admin.",
            "'" . $module_name . "'",
            $manage_path . "list",
            $manage_path . "form",
            $manage_path . "delete",
            $primary_key,
            $template_add_post_replace_root,
        ];
        $string_controller = str_replace($string_controller_from, $string_controller_to, $string_controller);

        if (empty($manage_path)) {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php', $string_controller);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/Controllers/Manage.php');
            }
        } else {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php', $string_controller);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name_class . 'Manage.php');
            }
        }

        $string_list_tpl   = file_get_contents(APPPATH . 'Modules/Dummy/Views/manage/list.tpl');
        $string_form_tpl   = file_get_contents(APPPATH . 'Modules/Dummy/Views/manage/form.tpl');
        $string_delete_tpl = file_get_contents(APPPATH . 'Modules/Dummy/Views/manage/delete.tpl');

        $string_list_tpl   = str_replace(
            ["dummy_id", "lang('Dummy.", "'dummy'"],
            [$primary_key, "lang('" . $language_name_class . "Admin.", "'" . $module_name . "'"],
            $string_list_tpl
        );

        $string_form_tpl   = str_replace(
            ["dummy_id", "{*TPL_DUMMY_ROOT*}", "{*TPL_DUMMY_DESCRIPTION*}", "lang('Dummy.", "dummy_lang"],
            [$primary_key, $template_replace_root, $template_replace_description, "lang('" . $language_name_class . "Admin.", $table_name_language],
            $string_form_tpl
        );

        $string_delete_tpl = str_replace(
            ["dummy_id", "dummy_lang"],
            [$primary_key, $table_name_language],
            $string_delete_tpl
        );

        if (empty($manage_path)) {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl', $string_list_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/list.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl', $string_form_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/form.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl', $string_delete_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/delete.tpl');
            }
        } else {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl', $string_list_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/list.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl', $string_form_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/form.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl', $string_delete_tpl);
                chmode(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/delete.tpl');
            }
        }

        $string_model_manager             = file_get_contents(APPPATH . 'Modules/Dummy/Models/DummyModel.php');
        $string_model_description_manager = file_get_contents(APPPATH . 'Modules/Dummy/Models/DummyLangModel.php');

        $string_model_manager = str_replace(
            [
                "App\Modules\Dummy\Models",
                "DummyModel extends",
                "dummy';",
                "dummy_id",
                "dummy.",
                "dummy_lang",
                "//FIELD_ROOT"
            ],
            [
                "App\Modules\\" . $module_name_class . "\Models",
                $model_name_class . "Model extends",
                $table_name . "';",
                $primary_key,
                $table_name . ".",
                $table_name_language,
                $field_root
            ],
            $string_model_manager
        );

        if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php')) {
            write_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php', $string_model_manager);
            chmod(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), '/Models/' . $model_name_class . 'Model.php');
        }

        $string_model_description_manager = str_replace(
            [
                "App\Modules\Dummy\Models",
                "DummyLangModel extends", 
                "dummy_lang';",
                "'dummy'", //$with = ['dummy'];
                "dummy_id", 
                "//FIELD_DESCRIPTION"
            ],
            [
                "App\Modules\\" . $module_name_class . "\Models",
                $model_name_class . "LangModel extends",
                $table_name_language . "';", 
                "'" . $table_name . "'",
                $primary_key,
                $field_description
            ],
            $string_model_description_manager
        );

        if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'LangModel.php')) {
            write_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'LangModel.php', $string_model_description_manager);
            chmod(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'LangModel.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), '/Models/' . $model_name_class . 'LangModel.php');
        }

        $string_config_manager = file_get_contents(APPPATH . 'Modules/Dummy/Config/Routes.php');
        $string_config_manager = str_replace(
            ["dummy", "App\Modules\Dummy\Controllers"],
            [$module_name, "App\Modules\\" . $module_name_class . "\Controllers"],
            $string_config_manager
        );

        if (!empty($manage_path)) {
            $string_config_manager = str_replace(
                ["groups_manage", "GroupsManage"],
                [$module_name . "_manage", $module_name_class . "Manage"],
                $string_config_manager
            );
        }

        if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php')) {
            write_file(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php', $string_config_manager);
            chmod(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), '/Config/Routes.php');
        }

        if (empty($error_created)) {
            $data['success'] = lang('Builder.created_success');
        } else {
            $data['error_created'] = $error_created;
        }

        $data['tool_manage'] = base_url($manage_name_controller . "manage");

        return $data;
    }

    private function _addFormSingle()
    {
        // get data from form
        $module_name     = strtolower($this->request->getPost('module_name'));
        $controller_name = strtolower($this->request->getPost('controller_name'));
        $model_name      = strtolower($this->request->getPost('model_name'));
        $table_name      = strtolower($this->request->getPost('table_name'));

        if (empty($module_name) || empty($controller_name) || empty($model_name)) {
            set_alert(lang('Amin.error'), ALERT_ERROR);
            return redirect()->to(site_url(self::MANAGE_URL));
        }

        //neu ten table khong tai thi su sung ten model lam table
        if (empty($table_name)) {
            $table_name = $model_name;
        }

        if (!$this->db->tableExists($table_name)) {
            set_alert(sprintf(lang('Builder.error_table_not_found'), $table_name, ''), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if ($controller_name == "manage") {
            $controller_name = $module_name;
        }
        $module_name_class     = ucfirst($module_name);
        $controller_name_class = ucfirst($controller_name);
        $model_name_class      = ucfirst($model_name);
        $language_name_class   = ($module_name != $controller_name)? singular(ucfirst($module_name)) . singular(ucfirst($controller_name)) : singular(ucfirst($controller_name));

        // create module
        if (!is_dir(APPPATH . "Modules/" . $module_name_class)) {
            mkdir(APPPATH . 'Modules/' . $module_name_class, 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Config')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Config', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Controllers')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Controllers', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Models')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Models', 0777, true);
        }
        if (!is_dir(APPPATH . "Modules/" . $module_name_class . '/Views')) {
            mkdir(APPPATH . 'Modules/'. $module_name_class . '/Views', 0777, true);
        }

        //write language
        $string_language_vn = file_get_contents(APPPATH . 'Language/vi/Dummy.php');
        $string_language_en = file_get_contents(APPPATH . 'Language/en/Dummy.php');

        $string_language_vn = str_replace('Dummy', $controller_name_class, $string_language_vn);
        $string_language_en = str_replace('Dummy', $controller_name_class, $string_language_en);

        if (!is_file(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php')) {
            write_file(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php', $string_language_vn);
            chmod(APPPATH . 'Language/vi/' . $language_name_class . 'Admin.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), 'vi/' . $language_name_class . 'Admin.php');
        }

        if (!is_file(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php')) {
            write_file(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php', $string_language_en);
            chmod(APPPATH . 'Language/en/' . $language_name_class . 'Admin.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), 'en/' .  $language_name_class . 'Admin.php');
        }

        $manage_path = '';
        $manage_name_controller = $module_name . '/';
        // neu la controller con cua module
        if ($module_name != $controller_name) {
            $manage_path = $controller_name . '/';
            $manage_name_controller = $module_name . '/' . $controller_name . '_';

            if (!is_dir(APPPATH . 'Modules/'. $module_name_class . '/Views/' . $controller_name)) {
                mkdir(APPPATH . 'Modules/'. $module_name_class . '/Views/' . $controller_name, 0777, true);
            } else {
                $error_created[] = sprintf(lang('Builder.folder_created'), $controller_name );
            }
        }

        //template su dung cho tpl add va edit
        $template_field_root = "
                <div class=\"form-group row\">
                    <label class=\"col-12 col-sm-3 text-sm-end col-form-label\">
                        {lang('%sAdmin.text_%s')}
                    </label>
                    <div class=\"col-12 col-sm-8 col-lg-6\">
                        {if isset(\$edit_data.%s)}
                            {assign var=\"%s\" value=\"`\$edit_data.%s`\"}
                        {else}
                            {assign var=\"%s\" value=\"\"}
                        {/if}
                        <input type=\"text\" name=\"%s\" value=\"{old('%s', \$%s)}\" id=\"%s\" class=\"form-control\">
                    </div>
                </div>";


        //template khi post data khi add va edit
        $template_add_post_root = "
                '%s' => \$this->request->getPost('%s'),";

        $template_replace_root        = ""; // : {*TPL_DUMMY_ROOT*}
        $template_add_post_replace_root = ""; // : //ADD_DUMMY_ROOT

        $field_root = ""; // : //FIELD_ROOT
        $field_description = ""; // : //FIELD_DESCRIPTION

        $primary_key = "";

        // get data field root
        if ($this->db->tableExists($table_name) ) {
            $fields = $this->db->getFieldData($table_name);

            if (!empty($fields)) {
                $list_not_add = [$table_name . '_id', 'name', 'description'];
                foreach ($fields as $field) {
                    if (!empty($field->primary_key)) {
                        $primary_key = $field->name;
                        continue;
                    }
                    if (in_array($field->name, $list_not_add)) {
                        continue;
                    }
                    $field_root .= '"' . $field->name . '",' . PHP_EOL;

                    //them field cho tpl add va edit
                    $template_replace_root .= sprintf(
                        $template_field_root,
                        $language_name_class,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                        $field->name,
                    );
                    //them field khi submit trong manage
                    $template_add_post_replace_root .= sprintf(
                        $template_add_post_root,
                        $field->name,
                        $field->name,
                    );
                }
            }
        }

        //write class controller
        $string_controller = file_get_contents(APPPATH . 'Modules/Dummy/Controllers/GroupsManage.php');

        $string_controller_from = [
            "App\Modules\Dummy\Controllers",
            "App\Modules\Dummy\Models\GroupModel",
            "class GroupsManage extends",
            "dummy/groups_manage", //MANAGE_ROOT & MANAGE_URL
            "new GroupModel()", // $this->model = new GroupModel();
            "lang('Dummy.", //language
            "'dummy'", //paging
            "group/list",
            "group/form",
            "group/delete",
            "dummy_id",
            "//ADD_DUMMY_ROOT",
        ];

        $controller_name_class_tpm =  ($module_name != $controller_name) ? "class " . $controller_name_class . "Manage extends" : "class Manage extends";

        $string_controller_to = [
            "App\Modules\\" . $module_name_class . "\Controllers",
            "App\Modules\\" . $module_name_class . "\Models\\" . $model_name_class . "Model",
            $controller_name_class_tpm,
            $manage_name_controller . "manage",
            "new " . $model_name_class . "Model()",
            "lang('" . $language_name_class . "Admin.",
            "'" . $module_name . "'",
            $manage_path . "list",
            $manage_path . "form",
            $manage_path . "delete",
            $primary_key,
            $template_add_post_replace_root,
        ];
        $string_controller = str_replace($string_controller_from, $string_controller_to, $string_controller);

        if (empty($manage_path)) {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php', $string_controller);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Controllers/Manage.php', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/Controllers/Manage.php');
            }
        } else {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php', $string_controller);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Controllers/' . $controller_name_class . 'Manage.php', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name_class . 'Manage.php');
            }
        }

        $string_list_tpl   = file_get_contents(APPPATH . 'Modules/Dummy/Views/groups/list.tpl');
        $string_form_tpl   = file_get_contents(APPPATH . 'Modules/Dummy/Views/groups/form.tpl');
        $string_delete_tpl = file_get_contents(APPPATH . 'Modules/Dummy/Views/groups/delete.tpl');

        $string_list_tpl = str_replace(
            ["dummy_id", "lang('Dummy.", "'dummy'"],
            [$primary_key, "lang('" . $language_name_class . "Admin.", "'" . $module_name . "'"],
            $string_list_tpl
        );

        $string_form_tpl = str_replace(
            ["dummy_id", "{*TPL_DUMMY_ROOT*}", "lang('Dummy."],
            [$primary_key . "_id", $template_replace_root, "lang('" . $language_name_class . "Admin."],
            $string_form_tpl
        );

        $string_delete_tpl = str_replace(
            "dummy_id",
            $primary_key,
            $string_delete_tpl
        );

        if (empty($manage_path)) {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl', $string_list_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/list.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/list.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl', $string_form_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/form.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/form.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl', $string_delete_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/delete.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), '/delete.tpl');
            }
        } else {
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl', $string_list_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/list.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/list.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl', $string_form_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/form.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/form.tpl');
            }
            if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl')) {
                write_file(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl', $string_delete_tpl);
                chmod(APPPATH . 'Modules/' . $module_name_class . '/Views/' . $controller_name . '/delete.tpl', 0777);
            } else {
                $error_created[] = sprintf(lang('Builder.file_created'), $controller_name . '/delete.tpl');
            }
        }

        $string_model_manager = file_get_contents(APPPATH . 'Modules/Dummy/Models/GroupModel.php');

        $string_model_manager = str_replace(
            ["App\Modules\Dummy\Models", "GroupModel extends", "dummy_group';", "dummy_id", "//FIELD_ROOT"],
            ["App\Modules\\" . $module_name_class . "\Models", $model_name_class . "Model extends",  $table_name . "';", $primary_key, $field_root],
            $string_model_manager
        );

        if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php')) {
            write_file(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php', $string_model_manager);
            chmod(APPPATH . 'Modules/' . $module_name_class . '/Models/' . $model_name_class . 'Model.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), '/Models/' . $model_name_class . 'Model.php');
        }

        $string_config_manager = file_get_contents(APPPATH . 'Modules/Dummy/Config/Routes.php');
        $string_config_manager = str_replace(
            ["dummy", "App\Modules\Dummy\Controllers"],
            [$module_name, "App\Modules\\" . $module_name_class . "\Controllers"],
            $string_config_manager
        );

        if (!empty($manage_path)) {
            $string_config_manager = str_replace(
                ["groups_manage", "GroupsManage"],
                [$module_name . "_manage", $module_name_class . "Manage"],
                $string_config_manager
            );
        }

        if (!is_file(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php')) {
            write_file(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php', $string_config_manager);
            chmod(APPPATH . 'Modules/' . $module_name_class . '/Config/Routes.php', 0777);
        } else {
            $error_created[] = sprintf(lang('Builder.file_created'), '/Config/Routes.php');
        }

        if (empty($error_created)) {
            $data['success'] = lang('Builder.created_success');
        } else {
            $data['error_created'] = $error_created;
        }

        $data['tool_manage'] = base_url($manage_name_controller . "manage");

        return $data;
    }

    private function _rrmdir($src)
    {
        try {
            $dir = opendir($src);
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    $full = $src . '/' . $file;
                    if ( is_dir($full) ) {
                        $this->_rrmdir($full);
                    }
                    else {
                        unlink($full);
                    }
                }
            }
            closedir($dir);
            rmdir($src);
        } catch (\Exception $ex) {
            die($ex->getMessage());
            return false;
        }
        return  true;
    }
}
