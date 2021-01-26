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
     * @param $filename
     * @param $width
     * @param $height
     * @return string|void
     */
    public function resize($filename, $width = null, $height = null)
    {
        $width = !empty($width) ? $width : (!empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH);
        $height = !empty($height) ? $height : (!empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT);

        if (!is_file($this->dir_image_path . $filename) || substr(str_replace('\\', '/', realpath($this->dir_image_path . $filename)), 0, strlen($this->dir_image_path)) != $this->dir_image_path) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = UPLOAD_FILE_CACHE_DIR . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (is_file($this->dir_image_path . $image_new)) {
            $file_info_old = get_file_info($this->dir_image_path . $image_old);
            $file_info_new = get_file_info($this->dir_image_path . $image_new);

            if (isset($file_info_old['date']) && isset($file_info_new['date']) && $file_info_old['date'] > $file_info_new['date']) {
                delete_files(unlink($this->dir_image_path . $image_new));
            }
        }

        $image_old_info = getimagesize($this->dir_image_path . $image_old);
        if (isset($image_old_info[0]) && isset($image_old_info[1]) && $width > $image_old_info[0] && $height > $image_old_info[0]) {
            write_file($this->dir_image_path . $image_new, file_get_contents($this->dir_image_path . $image_old));
            return $image_new;
        }

        if (!is_file($this->dir_image_path . $image_new)) {
            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir($this->dir_image_path . $path)) {
                    @mkdir($this->dir_image_path . $path, 0777);
                }
            }

            $quality = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;
            $master_dimm = !empty(config_item('image_master_dimm')) ? config_item('image_master_dimm') : 'width';

            $this->image = \Config\Services::image('imagick');
            $this->image->withFile($this->dir_image_path . $image_old)
                ->resize($width, $height, true, $master_dimm)
                ->save($this->dir_image_path . $image_new, $quality);
        }

        return $image_new;
    }

    public function rotation($filename, $angle = '90')
    {
        if (!is_file($this->dir_image_path . $filename)) {
            return false;
        }

        $config['image_library']  = 'gd2';
        $config['source_image']   = $this->dir_image_path . $filename;
        $config['rotation_angle'] = $angle;
        $config['quality']        = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;

        $this->image->clear();
        $this->image->initialize($config);

        if (!$this->image->rotate()) {
            error_log($this->image->display_errors());
            return false;
        }

        return $this->resize($filename);
    }
    
    public function crop($filename, $width, $height, $x_axis, $y_axis, $is_new = false)
    {
        $image_root = $filename;
        if (!is_file($this->dir_image_path . $filename)) {
            return false;
        }
        $source_img = $this->dir_image_path . $filename;

        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $source_img,
            'new_image'      => $source_img,
            'quality'        => !empty(config_item('image_quality')) ? config_item('image_quality') : 100,
            'maintain_ratio' => FALSE,
            'width'          => $width,
            'height'         => $height,
            'x_axis'         => $x_axis,
            'y_axis'         => $y_axis,
        ];

        $this->image->clear();
        $this->image->initialize($config);

        if (!$this->image->crop()) {
            error_log($this->image->display_errors());
            return false;
        }

        return $image_root;
    }

    public function watermark($filename, $position = null)
    {
        $image_root = $filename;

        $watermark_text = !empty(config_item('image_watermark_text')) ? config_item('image_watermark_text') : null;
        $watermark_path = !empty(config_item('image_watermark_path')) ? config_item('image_watermark_path') : null;
        if (empty($watermark_text) && empty($watermark_path)) {
            return $image_root;
        }

        if (!empty($watermark_path) && !is_file($this->dir_image_path . $watermark_path)) {
            return $image_root;
        }

        if (!is_file($this->dir_image_path . $filename)) {
            return $image_root;
        }

        $position = !empty($position) ? $position : (!empty(config_item('image_watermark')) ? config_item('image_watermark') : null);
        if (empty($position)) {
            return $image_root;
        }

        $position_tmp = explode('_', $position);
        if (!empty($watermark_path)) {

            $config = [
                'source_image'     => $this->dir_image_path . $filename,
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
                'source_image' => $this->dir_image_path . $filename,
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

    public function watermark_demo($filename = null)
    {
        $filename = !empty($filename) ? get_upload_path() . $filename : FCPATH . 'content/common/images/watermark_bg.jpg';

        $watermark = 'tmp/watermark_bg.jpg';
        if (is_file(get_upload_path() . $watermark)) {
            delete_files(unlink(get_upload_path() . $watermark));
        }
        write_file(get_upload_path() . $watermark, read_file($filename));

        //$this->resize($watermark, config_item('image_width_pc'), config_item('image_height_pc'));
        $this->watermark($watermark);

        return base_url() . get_upload_url('tmp/watermark_bg.jpg');
    }
}
