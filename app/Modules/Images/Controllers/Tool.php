<?php namespace App\Modules\Images\Controllers;

use App\Controllers\MyController;

class Tool extends MyController
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

    public function alt($wh = null, $background = null, $foreground = null)
    {
        $params = [];
        if (empty($wh)) {
            $params['width']  = 300;
            $params['height'] = 230;
        } else {
            $wh_tmp = explode("x", strtolower($wh));
            $params['width']  = $wh_tmp[0];
            $params['height'] = isset($wh_tmp[1]) ? $wh_tmp[1] : $wh_tmp[0];
        }

        $params['height']     = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']       = (empty($this->request->getGet("text"))) ? $params['width'].'x'. $params['height'] : $this->request->getGet("text");
        $params['background'] = (empty($background)) ? 'CCCCCC' : $background;
        $params['foreground'] = (empty($foreground)) ? '969696' : $foreground;

        $alt_url = 'http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'];

        $client = \Config\Services::curlrequest();
        $response_alt = $client->get($alt_url);

        $this->response
            ->setStatusCode(200)
            ->setContentType(preg_replace('/\s+/','', $response_alt->getHeader('Content-Type')->getValue()))
            ->setBody(file_get_contents_ssl($alt_url))
            ->send();
    }

    public function crop()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!empty($this->request->getPost())) {
            $image_crop = $this->request->getPost("path");
            if (!is_file($this->_image_path . $image_crop) || empty($image_crop)) {
                json_output(['error' => 'File not found']);
            }

            $width   = $this->request->getPost("width");
            $height  = $this->request->getPost("height");
            $xoffset = $this->request->getPost("xoffset");
            $yoffset = $this->request->getPost("yoffset");


            $image_tool = new \App\Libraries\ImageTool();
            $image_tool->crop($image_crop, $width, $height, $xoffset, $yoffset);

            json_output(['success' => true, 'image' => $image_crop . '?' . time()]);
        }

        $image_url = $this->request->getGet('image_url');
        if (!is_file($this->_image_path . $image_url) || empty($image_url)) {
            json_output(['error' => 'File not found']);
        }
        $image_info = getimagesize($this->_image_path . $image_url);

        $aspect_ratio = '16/9';

        $data['image_url']    = $image_url;
        $data['aspect_ratio'] = empty($this->request->getGet('preserve_aspect_ratio')) ? 'false' : 'true';
        $data['mime']         = $image_info['mime'];


        return $this->themes::view('crop', $data);
    }
}
