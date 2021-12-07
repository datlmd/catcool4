<?php
namespace App\Controllers;

use App\Controllers\MyController;

class ApiController extends MyController
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
