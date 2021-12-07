<?php
namespace App\Controllers;

use App\Controllers\MyController;

class AjaxController extends MyController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->request->isAJAX())
        {

        }
    }
}
