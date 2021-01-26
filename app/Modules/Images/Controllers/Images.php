<?php namespace App\Modules\Images\Controllers;

class Images extends BaseController
{
    private $_image_path = '';
    private $_image_url  = '';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('images/image_tool', 'image_tool');

        helper('file');

        $this->lang->load('images', $this->_site_lang);

        $this->_image_path = get_upload_path();
        $this->_image_url  = get_upload_url();
    }

    public function index()
    {
        $image_url = $this->input->get("c");

        $width  = (is_mobile()) ? config_item('image_width_mobile') : config_item('image_width_pc');
        $height = (is_mobile()) ? config_item('image_height_mobile') : config_item('image_height_pc');

        $computedImage = image_thumb_url($image_url, $width, $height);

        $this->output->set_content_type(get_mime_by_extension($computedImage))->set_output(file_get_contents_ssl($computedImage));
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
        $params['text']       = (empty($this->input->get("text", true))) ? $params['width'].' x '. $params['height'] : $this->input->get("text", true);
        $params['background'] = (empty($background)) ? 'CCCCCC' : $background;
        $params['foreground'] = (empty($foreground)) ? '969696' : $foreground;

        $alt_url = 'http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'];

        $this->output->set_content_type(get_mime_by_extension($alt_url))->set_output(file_get_contents_ssl($alt_url));
    }

    public function crop()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (isset($_POST) && !empty($_POST))
        {
            $image_crop = $this->input->post("path");
            if (!is_file($this->_image_path . $image_crop) || empty($image_crop)) {
                json_output(['error' => 'File not found']);
            }

            $img = $this->input->post("image_data");
            $img = str_replace(['data:image/jpeg;base64,', '[removed]'], ['', ''], $img);
            $img = str_replace(' ', '+', $img);

            file_put_contents($this->_image_path . $image_crop, base64_decode($img));

            //resize small size
            $this->load->helper('image');
            $image_resize = new Image($this->_image_path . $image_crop);
            $image_resize->resize($image_resize->getWidth(),$image_resize->getHeight());
            $quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 90;
            $image_resize->save($this->_image_path . $image_crop, $quality);

            json_output(['success' => true, 'image' => $this->_image_url . $image_crop . '?' . time()]);
        }
        else
        {
            $image_url = $this->input->get('image_url');
            if (!is_file($this->_image_path . $image_url) || empty($image_url)) {
                json_output(['error' => 'File not found']);
            }
            $image_info = getimagesize($this->_image_path . $image_url);

            $aspect_ratio = '16/9';

            $data['image_url']    = $image_url;
            $data['aspect_ratio'] = empty($this->input->get('preserve_aspect_ratio')) ? 'false' : 'true';
            $data['mime']         = $image_info['mime'];

            theme_view('crop', $data);
        }
    }

    public function crop_bk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (isset($_POST) && !empty($_POST))
        {
            $image_crop = $this->input->post("path");
            if (!is_file($this->_image_path . $image_crop) || empty($image_crop)) {
                json_output(['error' => 'File not found']);
            }

            $img = $this->input->post("image_data");
            $img = str_replace(['data:image/jpeg;base64,', '[removed]'], ['', ''], $img);
            $img = str_replace(' ', '+', $img);

            file_put_contents($this->_image_path . $image_crop, base64_decode($img));

            json_output(['success' => true, 'image' => $this->_image_url . $image_crop . '?' . time()]);
        }
        else
        {
            $image_url = $this->input->get('image_url');
            if (!is_file($this->_image_path . $image_url) || empty($image_url)) {
                json_output(['error' => 'File not found']);
            }
            $image_info = getimagesize($this->_image_path . $image_url);

            $aspect_ratio = '16/9';
            if (!empty($image_info) && count($image_info) > 2) {
                $min_container_width = $image_info[0];
                $min_container_height = $image_info[1];
                if (-15 < $min_container_width - $min_container_height && $min_container_width - $min_container_height < 15) {
                    $aspect_ratio = '1/1';
                } elseif ($min_container_width < $min_container_height) {
                    $aspect_ratio = '2/3';
                }
            }

            if (is_mobile()) {
                $min_container_width = 280;
                $min_container_height = 160;
            } else {
                if (empty($min_container_width) || $min_container_width > 800) {
                    $min_container_width = 800;
                }

                if (empty($min_container_height) || $min_container_height > 700) {
                    $min_container_height = 700;
                }
            }

            $data['image_url']            = $image_url;
            $data['aspect_ratio']         = $aspect_ratio;
            $data['min_container_width']  = $min_container_width;
            $data['min_container_height'] = $min_container_height;
            $data['mime']                 = $image_info['mime'];

            theme_view('crop', $data);
        }
    }
}
