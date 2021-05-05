<?php namespace App\Modules\Images\Controllers;

use App\Controllers\BaseController;

class File extends BaseController
{
    private $_file_path;
    private $_file_url;

    public function __construct()
    {
        parent::__construct();

        helper('filesystem');

        $this->_file_path = get_upload_path();
        $this->_file_url  = get_upload_url();
    }

    public function index()
    {
        try {
            $file_url = str_replace([base_url('file/'), UPLOAD_FILE_DIR], ['', ''], current_url());
            if (!is_file($this->_file_path . $file_url)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $file = new \CodeIgniter\Files\File($this->_file_path . $file_url);

            $this->response
                ->setStatusCode(200)
                ->setContentType($file->getMimeType())
                ->setBody(file_get_contents($this->_file_path . $file_url))
                ->send();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            //die($e->getMessage());
        }
    }
}
