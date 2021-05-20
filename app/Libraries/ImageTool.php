<?php namespace App\Libraries;

use Intervention\Image\ImageManager;

class ImageTool
{
    protected $image;
    protected $dir_image_path;

    protected $upload_type = 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP,webp,WEBP,tiff,TIFF,svg,SVG,svgz,SVGZ,psd,PSD,raw,RAW,heif,HEIF,indd,INDD,ai,AI';

    private $_driver = 'imagick'; //gd,gd2,imagick
    private $_quality;

    public function __construct()
    {
        helper('filesystem');

        $this->image = \Config\Services::image();

        $this->dir_image_path = get_upload_path();

        $this->_quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;
    }

    /**
     * resize tao hinh thumbnail, hinh goc van khong anh huong
     *
     * @param $file_name
     * @param $width
     * @param $height
     * @return string|void
     */
    public function resize($file_name, $width = null, $height = null)
    {
        $width = !empty($width) ? $width : (!empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH);
        $height = !empty($height) ? $height : (!empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT);

        if (!is_file($this->dir_image_path . $file_name) || substr(str_replace('\\', '/', realpath($this->dir_image_path . $file_name)), 0, strlen($this->dir_image_path)) != $this->dir_image_path) {
            return false;
        }

        $extension = pathinfo($file_name, PATHINFO_EXTENSION);

        $image_old = $file_name;
        $image_new = UPLOAD_FILE_CACHE_DIR . substr($file_name, 0, strrpos($file_name, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (is_file($this->dir_image_path . $image_new)) {
            $file_info_old = get_file_info($this->dir_image_path . $image_old);
            $file_info_new = get_file_info($this->dir_image_path . $image_new);

            if (isset($file_info_old['date']) && isset($file_info_new['date']) && $file_info_old['date'] > $file_info_new['date']) {
                delete_files(unlink($this->dir_image_path . $image_new));
            }
        }

        //create folder
        $path = '';
        $directories = explode('/', dirname($image_new));
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;

            if (!is_dir($this->dir_image_path . $path)) {
                mkdir($this->dir_image_path . $path, 0777);
            }
        }

        $image_old_info = getimagesize($this->dir_image_path . $image_old);
        if (isset($image_old_info[0]) && isset($image_old_info[1]) && $width > $image_old_info[0] && $height > $image_old_info[1]) {
            write_file($this->dir_image_path . $image_new, file_get_contents($this->dir_image_path . $image_old));
            return $image_new;
        }

        if (!is_file($this->dir_image_path . $image_new)) {

            $master_dimm = !empty(config_item('image_master_dimm')) ? config_item('image_master_dimm') : 'width';

            try {
                \Config\Services::image($this->_driver)->withFile($this->dir_image_path . $image_old)
                    ->resize($width, $height, true, $master_dimm)
                    ->save($this->dir_image_path . $image_new, $this->_quality);
            } catch (\Exception $e) {
                log_message('error', $e->getMessage());
                return false;
            }
        }

        return $image_new;
    }

    function resizeUpload($file)
    {
        if (empty($file) || empty(config_item('enable_resize_image'))) {
            return false;
        }

        if (!is_file($this->dir_image_path . $file) && !is_file($file)) {
            return false;
        }

        $file_path = $this->dir_image_path . $file;
        if (!is_file($file_path)) {
            $file_path = $file;
        }

        $extension = pathinfo($file_path, PATHINFO_EXTENSION);
        if (!in_array($extension, explode(',', $this->upload_type))) {
            return false;
        }

        $image_info = getimagesize($file_path);
        if (!isset($image_info[0]) || !isset($image_info[1])) {
            return false;
        }

        list($resize_width, $resize_height) = get_image_resize_info($image_info[0], $image_info[1]);

        $master_dimm = !empty(config_item('image_master_dimm')) ? config_item('image_master_dimm') : 'width';

        try {
            \Config\Services::image($this->_driver)->withFile($file_path)
                ->resize($resize_width, $resize_height, true, $master_dimm)
                ->save($file_path, $this->_quality);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }

        return $file;
    }

    public function rotation($file_name, $angle = '90')
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return false;
        }

        try {
            $this->image = \Config\Services::image($this->_driver);

            if (in_array($angle, ['hor', 'horizontal', 'vrt', 'vertical'])) {
                if ($angle == 'hor') {
                    $angle = 'horizontal';
                } elseif ($angle == 'vrt') {
                    $angle = 'vertical';
                }
                $this->image->withFile($this->dir_image_path . $file_name)
                    ->flip($angle)
                    ->save($this->dir_image_path . $file_name, $this->_quality);
            } else {
                $this->image->withFile($this->dir_image_path . $file_name)
                    ->reorient()
                    ->rotate($angle)
                    ->save($this->dir_image_path . $file_name, $this->_quality);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }

        return $file_name;
    }

    public function getInfo($file_name)
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return null;
        }

        try {
            $info = \Config\Services::image($this->_driver)->withFile($this->dir_image_path . $file_name)
                ->getFile()
                ->getProperties(true);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }

        return $info;
    }

    /**
     * @param $file_name
     * @param $file_new
     * @param $width
     * @param $height
     * @param $position: ‘top-left’, ‘top’, ‘top-right’, ‘left’, ‘center’, ‘right’, ‘bottom-left’, ‘bottom’, ‘bottom-right’.
     * @return bool
     */
    public function thumb($file_name, $file_new, $width, $height, $position = 'center')
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return false;
        }

        try {
            \Config\Services::image($this->_driver)->withFile($this->dir_image_path . $file_name)
                ->fit($width, $height, $position)
                ->save($this->dir_image_path . $file_new, $this->_quality);
        }
        catch (\Exception $e)
        {
            log_message('error', $e->getMessage());
            return false;
        }

        return $file_new;
    }
    public function crop($file_name, $width, $height, $xOffset, $yOffset, $is_new = false)
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return false;
        }

        try {
            // create an image manager instance with favored driver
            $manager = new ImageManager();//['driver' => $this->_driver]

            // to finally create image instances
            $manager->make($this->dir_image_path . $file_name)
                ->crop($width, $height, $xOffset, $yOffset)
                ->save($this->dir_image_path . $file_name, $this->_quality);

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }

        return $file_name;
    }

    public function convert($file_name, $file_new, $image_type = IMAGETYPE_PNG)
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return false;
        }

        try {
            \Config\Services::image($this->_driver)->withFile($file_name)
                ->convert($image_type)
                ->save($file_new, $this->_quality);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }

        return $file_new;
    }

    public function watermark($file_name, $position = null)
    {
        $image_root = $file_name;

        $watermark_text = !empty(config_item('image_watermark_text')) ? config_item('image_watermark_text') : null;
        $watermark_path = !empty(config_item('image_watermark_path')) ? config_item('image_watermark_path') : null;
        if (empty($watermark_text) && empty($watermark_path)) {
            return $image_root;
        }

        if (!empty($watermark_path) && !is_file($this->dir_image_path . $watermark_path)) {
            return $image_root;
        }

        if (!is_file($this->dir_image_path . $file_name)) {
            return $image_root;
        }

        $position = !empty($position) ? $position : (!empty(config_item('image_watermark')) ? config_item('image_watermark') : null);
        if (empty($position)) {
            return $image_root;
        }

        try {
            if (!empty(config_item('image_watermark_type'))
                && config_item('image_watermark_type') == 'image'
                && !empty($watermark_path)
            ) {
                $image_mgr     = new ImageManager();
                $watermark_mgr = new ImageManager();

                $image_new     = $image_mgr->make($this->dir_image_path . $file_name);
                $watermark_img = $watermark_mgr->make($this->dir_image_path . $watermark_path)
                    ->opacity(config_item('image_watermark_opacity'));

                if ($watermark_img->width() > $image_new->width() || $watermark_img->height() > $image_new->height()) {
                    $watermark_img->resize($image_new->width() , $image_new->height(), function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                $image_new->insert($watermark_img, $position, config_item('image_watermark_vrt_offset'), config_item('image_watermark_hor_offset'))
                    ->save($this->dir_image_path . $file_name, $this->_quality);

            } elseif (!empty(config_item('image_watermark_type'))
                && config_item('image_watermark_type') == 'text'
                && !empty($watermark_text)
            ) {

                if ($position == "top") {
                    $position = "top-center";
                } elseif ($position == "bottom") {
                    $position = "bottom-center";
                } elseif ($position == "center") {
                    $position = "middle-center";
                } elseif ($position == "left") {
                    $position = "middle-left";
                } elseif ($position == "right") {
                    $position = "middle-right";
                }

                $position_tmp = explode('-', $position);

                $font_path  = !empty(config_item('image_watermark_font_path')) ? ROOTPATH . config_item('image_watermark_font_path') : null;
                $font_size  = !empty(config_item('image_watermark_font_size')) ? config_item('image_watermark_font_size') : 16;
                $font_color = !empty(config_item('image_watermark_font_color')) ? config_item('image_watermark_font_color') : '#ffffff';

                $opacity       = config_item('image_watermark_opacity');
                $shadow_color  = !empty(config_item('image_watermark_shadow_color')) ? config_item('image_watermark_shadow_color') : '#f9f9f9';
                $shadow_offset = !empty(config_item('image_watermark_shadow_distance')) ? config_item('image_watermark_shadow_distance') : 3;

                $text_option = [
                    'color'        => $font_color,
                    'fontSize'     => $font_size,
                    'opacity'      => ($opacity == 0) ? 1 : (1 - ($opacity / 100)),
                    'vAlign'       => $position_tmp[0],
                    'hAlign'       => $position_tmp[1],
                    'vOffset'      => config_item('image_watermark_vrt_offset'),
                    'hOffset'      => config_item('image_watermark_hor_offset'),
                    'withShadow'   => !empty(config_item('image_watermark_is_shadow')),
                    'shadowColor'  => $shadow_color,
                    'shadowOffset' => $shadow_offset,
                ];

                if (!empty($font_path)) {
                    $text_option['fontPath'] = $font_path;
                }

                \Config\Services::image($this->_driver)
                    ->withFile($this->dir_image_path . $file_name)
                    ->text($watermark_text, $text_option)
                    ->save($this->dir_image_path . $file_name, $this->_quality);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $image_root;
        }

        return $image_root;
    }

    public function watermarkDemo($file_name = null)
    {
        $file_name = !empty($file_name) ? get_upload_path() . $file_name : FCPATH . 'common/images/watermark_bg.jpg';

        $watermark = 'cache/tmp/watermark_bg.jpg';
        if (is_file(get_upload_path() . $watermark)) {
            delete_files(unlink(get_upload_path() . $watermark));
        }

        if (!is_dir($this->dir_image_path . 'cache/tmp')) {
            mkdir($this->dir_image_path . 'cache/tmp', 0777);
        }

        \Config\Services::image($this->_driver)
            ->withFile($file_name)
            ->save(get_upload_path() . $watermark);

        //$this->resize($watermark, config_item('image_width_pc'), config_item('image_height_pc'));
        $this->watermark($watermark);

        return site_url() . "img/$watermark";
    }
}
