<?php

namespace App\Modules\Images\Controllers;

use App\Controllers\MyController;

class Upload extends MyController
{
    private $_image_path;
    private $_image_url;

    public function __construct()
    {
        parent::__construct();

        helper('filesystem');

        $this->_image_path = get_upload_path();
        $this->_image_url  = get_upload_url();
    }

    public function index()
    {
        try {
            //xoa file neu da expired sau 2 gio
            delete_file_upload_tmp();

            $json      = [];
            $valids    = [];
            $file_name = 'file'; //single

            // create folder
            if (!is_dir($this->_image_path . UPLOAD_FILE_TMP_DIR)) {
                mkdir($this->_image_path . UPLOAD_FILE_TMP_DIR, 0777, true);
            }

            // Validation
            $validation = \Config\Services::validation();

            $file_list = $this->request->getFiles();
            //multi
            if (!empty($file_list['files'])) {
                $file_key = 0;
                foreach ($file_list['files'] as $file) {
                    $valids["files.$file_key"] = $this->_getValids("files.$file_key", $file->getName());
                    $file_key++;
                }

                $validation->setRules($valids);
                if (!$validation->withRequest($this->request)->run()) {
                    json_output(['status' => 'ng', 'msg' => implode("<br/>", $validation->getErrors())]);
                }

                foreach ($file_list['files'] as $file) {
                    $json[] = $this->_upload($file);
                }
            } elseif (!empty($file_list['file'])) {
                $file = $this->request->getFile($file_name);

                $valids = $this->_getValids($file_name, $file->getName());
                $validation->setRules([
                    $file_name => $valids
                ]);

                if (!$validation->withRequest($this->request)->run()) {
                    json_output(['status' => 'ng', 'msg' => $validation->getError($file_name)]);
                }

                $json = $this->_upload($file);
            } else {
                json_output(['status' => 'ng', 'msg' => lang('Image.error_upload')]);
            }
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            json_output(['status' => 'ng', 'msg' => $ex->getMessage()]);
        }

        json_output($json);
    }

    private function _getValids($name, $file_name)
    {
        $allowed_types = !empty(config_item('file_ext_allowed')) ? config_item('file_ext_allowed') : 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP';
        $allowed_types = str_replace('|', ',', config_item('file_ext_allowed'));

        $max_size      = !empty(config_item('file_max_size')) ? config_item('file_max_size') : null;
        $max_width     = !empty(config_item('file_max_width')) ? config_item('file_max_width') : null;
        $max_height    = !empty(config_item('file_max_height')) ? config_item('file_max_height') : null;

        $valids = [
            sprintf('uploaded[%s]', $name),
            sprintf('ext_in[%s,%s]', $name, $allowed_types),
        ];

        if (!empty($max_size)) {
            $valids[] =  sprintf('max_size[%s,%s]', $name, $max_size);
        }

        if (!empty($max_width) && !empty($max_height)) {
            $valids[] =  sprintf('max_dims[%s,%d,%d]', $name, $max_width, $max_height);
        }

        $valids = [
            "label" => lang("Image.text_file") . " ($file_name)",
            "rules" => $valids,
        ];
        return $valids;
    }

    private function _upload($file)
    {
        // Get random file name
        $newName = trim($file->getRandomName());

        $file->move($this->_image_path . UPLOAD_FILE_TMP_DIR, $newName);

        // File path to display preview
        $filepath = UPLOAD_FILE_TMP_DIR . $newName;

        //resize image
        $image_tool = new \App\Libraries\ImageTool();
        $image_tool->resizeUpload($filepath);

        $file_info = get_file_info($this->_image_path . UPLOAD_FILE_TMP_DIR . $newName);

        $file_info = [
            'image_url' => $filepath,
            'file_name' => $file_info['name'],
            'file_size' => $file_info['size'],
        ];

        return $file_info;
    }
}
