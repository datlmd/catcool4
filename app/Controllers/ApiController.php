<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class ApiController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        // Check for CLI Request
        if (!$this->request->isCLI())
        {
            // ...
        }

    }
}
