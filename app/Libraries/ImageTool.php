<?php namespace App\Libraries;

class ImageTool
{
    protected $image;
    protected $dir_image_path;

    public function __construct()
    {
        helper('filesystem');

        $this->image = \Config\Services::image();

        $this->dir_image_path = get_upload_path();
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
            return;
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

            $quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;
            $master_dimm = !empty(config_item('image_master_dimm')) ? config_item('image_master_dimm') : 'width';

            try {
                \Config\Services::image('imagick')->withFile($this->dir_image_path . $image_old)
                    ->resize($width, $height, true, $master_dimm)
                    ->save($this->dir_image_path . $image_new, $quality);
            }
            catch (\Exception $e)
            {
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
        if (!in_array($extension, ['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF','bmp','BMP'])) {
            return false;
        }

        $image_info = getimagesize($file_path);
        if (!isset($image_info[0]) || !isset($image_info[1])) {
            return false;
        }

        list($resize_width, $resize_height) = get_image_resize_info($image_info[0], $image_info[1]);

        $quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;
        $master_dimm = !empty(config_item('image_master_dimm')) ? config_item('image_master_dimm') : 'width';

        try {
            \Config\Services::image('imagick')->withFile($file_path)
                ->resize($resize_width, $resize_height, true, $master_dimm)
                ->save($file_path, $quality);
        } catch (\Exception $e) {
            return false;
        }

        return $file;
    }

    public function rotation($file_name, $angle = '90')
    {
        if (!is_file($this->dir_image_path . $file_name)) {
            return false;
        }

        $quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;

        try {
            $this->image = \Config\Services::image('imagick');

            if (in_array($angle, ['hor', 'horizontal', 'vrt', 'vertical'])) {
                if ($angle == 'hor') {
                    $angle = 'horizontal';
                } elseif ($angle == 'vrt') {
                    $angle = 'vertical';
                }
                $this->image->withFile($this->dir_image_path . $file_name)
                    ->flip($angle)
                    ->save($this->dir_image_path . $file_name, $quality);
            } else {
                $this->image->withFile($this->dir_image_path . $file_name)
                    ->reorient()
                    ->rotate($angle)
                    ->save($this->dir_image_path . $file_name, $quality);
            }
        }
        catch (\Exception $e)
        {
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
            $info = \Config\Services::image('imagick')->withFile($this->dir_image_path . $file_name)
                ->getFile()
                ->getProperties(true);
        }
        catch (\Exception $e)
        {
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
            \Config\Services::image('imagick')->withFile($this->dir_image_path . $file_name)
                ->fit($width, $height, $position)
                ->save($this->dir_image_path . $file_new);
        }
        catch (\Exception $e)
        {
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
            \Config\Services::image('imagick')
                ->withFile($this->dir_image_path . $file_name)
                ->crop($width, $height, $xOffset, $yOffset)
                ->save($this->dir_image_path . $file_name);
        }
        catch (\Exception $e)
        {
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
            \Config\Services::image('imagick')->withFile($file_name)
                ->convert($image_type)
                ->save($file_new);
        }
        catch (\Exception $e)
        {
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

        $position_tmp = explode('_', $position);
        if (!empty($watermark_path)) {

            $config = [
                'source_image'     => $this->dir_image_path . $file_name,
                'wm_type'          => 'overlay',
                'quality'          => !empty(config_item('image_quality')) ? config_item('image_quality') : 100,
                'dynamic_output'   => FALSE,
                'wm_padding'       => null,
                'wm_vrt_alignment' => $position_tmp[0],
                'wm_hor_alignment' => $position_tmp[1],
                'wm_overlay_path'  => $this->dir_image_path . $watermark_path,
                'wm_opacity'       => !empty(config_item('image_watermark_opacity')) ? config_item('image_watermark_opacity') : 50,
                //'wm_x_transp'      => 4,
                //'wm_y_transp'      => 4,
            ];
        } else {
            $config = [
                'source_image' => $this->dir_image_path . $file_name,
                'wm_type' => 'text',
                'wm_text' => $watermark_text,
                'wm_font_path' => !empty(config_item('image_watermark_font_path')) ? config_item('image_watermark_font_path') : './system/fonts/texb.ttf',
                'wm_font_size' => !empty(config_item('image_watermark_font_size')) ? config_item('image_watermark_font_size') : 16,
                'wm_font_color' => !empty(config_item('image_watermark_font_color')) ? config_item('image_watermark_font_color') : 'ffffff',
                'wm_vrt_alignment' => $position_tmp[0],
                'wm_hor_alignment' => $position_tmp[1],
                'wm_padding' => 0,
                'wm_shadow_color'  => !empty(config_item('image_watermark_shadow_color')) ? config_item('image_watermark_shadow_color') : null,
                'wm_shadow_distance' => !empty(config_item('image_watermark_shadow_distance')) ? config_item('image_watermark_shadow_distance') : 3,
            ];
        }

        if (!empty(config_item('image_watermark_hor_offset'))) {
            $config['wm_hor_offset'] = config_item('image_watermark_hor_offset');
        }
        if (!empty(config_item('image_watermark_vrt_offset'))) {
            $config['wm_vrt_offset'] = config_item('image_watermark_vrt_offset');
        }

        $this->image->clear();
        $this->image->initialize($config);
        $this->image->watermark();

        return $image_root;
    }

    public function watermark_demo($file_name = null)
    {
        $file_name = !empty($file_name) ? get_upload_path() . $file_name : FCPATH . 'content/common/images/watermark_bg.jpg';

        $watermark = 'tmp/watermark_bg.jpg';
        if (is_file(get_upload_path() . $watermark)) {
            delete_files(unlink(get_upload_path() . $watermark));
        }
        write_file(get_upload_path() . $watermark, read_file($file_name));

        //$this->resize($watermark, config_item('image_width_pc'), config_item('image_height_pc'));
        $this->watermark($watermark);

        return base_url() . get_upload_url('tmp/watermark_bg.jpg');
    }
}
