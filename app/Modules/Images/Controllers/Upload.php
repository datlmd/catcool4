<?php namespace App\Modules\Images\Controllers;

use App\Controllers\BaseController;

class Upload extends BaseController
{
    private $_image_path;
    private $_image_url;

    const UPLOAD_TMP = 'tmp/';

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

            $json = [];

            // create folder
            if (!is_dir($this->_image_path . self::UPLOAD_TMP)) {
                mkdir($this->_image_path . self::UPLOAD_TMP, 0777, true);
            }

            $file_name     = 'file';
            $allowed_types = !empty(config_item('file_ext_allowed')) ?config_item('file_ext_allowed') : 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP';
            $max_size      = !empty(config_item('file_max_size')) ? config_item('file_max_size') : null;
            $max_width     = !empty(config_item('file_max_width')) ? config_item('file_max_width') : null;
            $max_height    = !empty(config_item('file_max_height')) ? config_item('file_max_height') : null;

            // Validation
            $validation = \Config\Services::validation();

            $valids = [
                sprintf('uploaded[%s]', $file_name),
                sprintf('ext_in[%s,%s]', $file_name, $allowed_types),
            ];

            if (!empty($max_size)) {
                $valids[] =  sprintf('max_size[%s,%s]', $file_name, $max_size);
            }

            if (!empty($max_width) && !empty($max_height)) {
                $valids[] =  sprintf('max_dims[%s,%d,%d]', $file_name, $max_width, $max_height);
            }

            $validation->setRules([
                $file_name => $valids
            ]);

            if ($validation->withRequest($this->request)->run() == FALSE){
                json_output(['status' => 'ng', 'msg' => $validation->getError($file_name)]);
            }

            if($file = $this->request->getFile($file_name))
            {
                // Get random file name
                $newName = $file->getRandomName();

                $file->move($this->_image_path . self::UPLOAD_TMP, $newName);

                // File path to display preview
                $filepath = self::UPLOAD_TMP . $newName;

                //resize image
                $image_tool = new \App\Libraries\ImageTool();
                $image_tool->resizeUpload($filepath);

                $file_info = get_file_info($this->_image_path . self::UPLOAD_TMP.$newName);

                $json = [
                    'image' => $filepath,
                    'file'  => [
                        'name' => $file_info['name'],
                        'size' => $file_info['size'],
                    ],
                ];
            } else {
                json_output(['status' => 'ng', 'msg' => lang('FileManager.error_upload')]);
            }

        } catch (\Exception $e) {
            json_output(['status' => 'ng', 'msg' => $e->getMessage()]);
        }

        json_output($json);
    }
}
