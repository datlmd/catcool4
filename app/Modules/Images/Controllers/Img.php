<?php namespace App\Modules\Images\Controllers;

use App\Controllers\BaseController;

class Img extends BaseController
{
    private $_image_path;
    private $_image_url;
    private $_image_tool;

    public function __construct()
    {
        parent::__construct();

        $this->_image_tool = new \App\Libraries\ImageTool();

        helper('filesystem');


        $this->_image_path = get_upload_path();
        $this->_image_url  = get_upload_url();
    }

    public function index($img_wh = null)
    {
        try {
            $agent = $this->request->getUserAgent();
            $width = 0;
            $height = 0;

            $image_url = str_replace([base_url('img/'), UPLOAD_FILE_DIR], ['', ''], current_url());

            if (!empty($img_wh)) {
                $img_wh = strtolower($img_wh);
                $img_wh = explode('/', $img_wh);
                if (!empty($img_wh[0]) && stripos($img_wh[0], "x") !== false) {
                    $wh_tmp = explode('x', $img_wh[0]);
                    $width = $wh_tmp[0];
                    $height = $wh_tmp[1];
                    $image_url = str_replace(sprintf('%sx%s/', $width, $height), '', $image_url);
                }
            }

            if (empty($width) || empty($height)) {
                $width = ($agent->isMobile()) ? config_item('image_width_mobile') : config_item('image_width_pc');
                $height = ($agent->isMobile()) ? config_item('image_height_mobile') : config_item('image_height_pc');
            }

            $image_url = $this->_image_tool->resize($image_url, $width, $height);
            if (!empty($image_url)) {
                $computedImage = $this->_image_path . $image_url;
                $computedImage = str_replace('//', '/', $computedImage);
            } else {
                $computedImage = image_default_path();
            }

            $file = new \CodeIgniter\Files\File($computedImage);

            $this->response
                ->setStatusCode(200)
                ->setContentType($file->getMimeType())
                ->setBody(file_get_contents($computedImage))
                ->send();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            //die($e->getMessage());
        }
    }
}
