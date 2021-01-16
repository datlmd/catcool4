<?php namespace App\Libraries;

require_once APPPATH.'ThirdParty/Smarty/Autoloader.php';

use \Smarty_Autoloader;

Smarty_Autoloader::register();

use \Smarty;

class CI4Smarty extends Smarty
{
    public $template_ext = 'tpl';

    public function __construct()
    {
        parent::__construct();

        parent::setTemplateDir('content/themes');
        parent::setCompileDir(WRITEPATH . 'smarty/templates_c/')->setCacheDir(WRITEPATH . 'smarty/cache/');

    }

    public function view($tpl_name) {
        if (substr($tpl_name, -4) != '.tpl'){
            $tpl_name.='.tpl';
        }

        parent::display($tpl_name);
    }
}