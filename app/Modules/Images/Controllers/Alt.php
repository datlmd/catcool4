<?php namespace App\Modules\Images\Controllers;

use App\Controllers\BaseController;

class Alt extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index($wh = null, $background = null, $foreground = null)
    {
        try {
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
            $params['text']       = (empty($this->request->getGet('text'))) ? $params['width'].' x '. $params['height'] : $this->request->getGet('text');
            $params['background'] = (empty($background)) ? 'CCCCCC' : $background;
            $params['foreground'] = (empty($foreground)) ? '969696' : $foreground;

            $alt_url = 'http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'];

            $this->response
                ->setStatusCode(200)
                ->setContentType('image/jpeg')
                ->setBody(file_get_contents($alt_url))
                ->send();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            //die($e->getMessage());
        }
    }
}
