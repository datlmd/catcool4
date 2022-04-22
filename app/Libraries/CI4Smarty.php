<?php namespace App\Libraries;

require_once APPPATH.'ThirdParty/Smarty/Autoloader.php';
require_once APPPATH.'ThirdParty/Smarty/Smarty.class.php';

use \Smarty_Autoloader;

Smarty_Autoloader::register();

use \Smarty;

class CI4Smarty extends Smarty
{
    public $template_ext = 'tpl';

    public function __construct()
    {
        parent::__construct();

        parent::setDebugging(FALSE);

        parent::setTemplateDir(FCPATH.'/themes');
        parent::setCompileDir(WRITEPATH . 'cache/smarty/templates_c/')->setCacheDir(WRITEPATH . 'cache/smarty/cache/');

        // Disable Smarty security policy
        parent::disableSecurity();
        parent::setErrorReporting(E_ALL & ~E_NOTICE);

        parent::muteUndefinedOrNullWarnings();

        //$this->assign("this", $this);

        $this->assign( 'FCPATH', FCPATH );     // path to website
        $this->assign( 'APPPATH', APPPATH );   // path to application directory
        $this->assign( 'ROOTPATH', ROOTPATH ); // path to system directory
        $this->assign( 'WRITEPATH', WRITEPATH ); // path to system directory
    }

    public function view($tpl_name)
    {
        if (substr($tpl_name, -4) != '.tpl'){
            $tpl_name.='.tpl';
        }

        parent::display($tpl_name);
    }
}