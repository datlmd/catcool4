<?php namespace App\Modules\Common\Controllers;

use App\Controllers\AdminController;
use App\Libraries\Themes;
use CodeIgniter\Cache\Exceptions\CacheException;
use CodeIgniter\HTTP\RequestInterface;

class FileManager extends AdminController
{
    protected $image_tool;
    protected $dir_image      = '';
    protected $dir_image_path = '';

    CONST PATH_SUB_NAME   = 'root';
    CONST FILE_PAGE_LIMIT = 20;//PAGINATION_MANAGE_DEFAULF_LIMIT;

    protected $upload_type = '';

    protected $image_thumb_width  = '';
    protected $image_thumb_height = '';

    public function __construct()
    {
        parent::__construct();

        helper('filesystem');
        $this->image_tool = new \App\Libraries\ImageTool();

        $this->request   = \Config\Services::request();
        $this->themes    = Themes::init();
        $this->validator = \Config\Services::validation();

        $this->dir_image      = get_upload_url();
        $this->dir_image_path = get_upload_path();

        $this->upload_type = 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP,webp,WEBP,tiff,TIFF,svg,SVG,svgz,SVGZ,psd,PSD,raw,RAW,heif,HEIF,indd,INDD,ai,AI';
        if (!empty($this->request->getGet('type')) && in_array($this->request->getGet('type'), ["image", "media"])) {
            if ($this->request->getGet('type') == "image") {
                $this->upload_type = 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP,webp,WEBP,tiff,TIFF,svg,SVG,svgz,SVGZ,psd,PSD,raw,RAW,heif,HEIF,indd,INDD,ai,AI';
            } else {
                $this->upload_type = 'webm,WEBM,mpg,MPG,mp2,MP2,mpeg,MPEG,mpe,MPE,mpv,MPV,ogg,OGG,mp4,MP4,m4p,M4P,m4v,M4V,avi,AVI,wmv,WMV,mov,MOV,qt,QT,flv,FLV,swf,SWF,avchd,AVCHD';
            }
        } elseif (!empty(config_item('file_ext_allowed'))) {
            $this->upload_type = str_replace('|', ',', config_item('file_ext_allowed'));
        }

        $this->image_thumb_width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
        $this->image_thumb_height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;
    }

    public function index()
    {
        $server = site_url();

        $filter_name = $this->request->getGet('filter_name');
        if (!empty($filter_name)) {
            $filter_name = rtrim(str_replace('*', '', $filter_name), '/');
        } else {
            $filter_name = null;
        }

        // Make sure we have the correct directory
        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . str_replace('*', '', $directory), '/');
        } else {
            $directory = $this->dir_image_path . self::PATH_SUB_NAME;
        }

        $page = $this->request->getGet('page');
        if (isset($page)) {
            $page = $page;
        } else {
            $page = 1;
        }

        $directories = [];
        $files = [];

        $data['images'] = [];

        if (substr(str_replace('\\', '/', realpath($directory . '/')), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) == $this->dir_image_path . self::PATH_SUB_NAME) {
            // Get directories
            $directories = glob($directory . '/*' . $filter_name . '*', GLOB_ONLYDIR);

            if (!$directories) {
                $directories = [];
            }

            $files = glob($directory . '/*' . $filter_name . '*.{' . $this->upload_type . '}', GLOB_BRACE);

            if (!$files) {
                $files = [];
            }
        }

        $file_size = [];
        $file_tmp = [];
        foreach ($files as $key => $file) {
            $file_info = get_file_info($file);
            $file_size[$file] = !empty($file_info['size']) ? $file_info['size'] : 0;
            $file_tmp[$file_info['date']] = $file;
        }
        krsort($file_tmp);

        // Merge directories and files
        $images = array_merge($directories, $file_tmp);

        // Get total number of files and directories
        $image_total = count($images);

        // Split the array based on current page number and max number of items per page of 10
        $images = array_splice($images, ($page - 1) * self::FILE_PAGE_LIMIT, self::FILE_PAGE_LIMIT);

        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {
                $url = '';

                $target = $this->request->getGet('target');
                if (isset($target)) {
                    $url .= '&target=' . $target;
                }
                $thumb = $this->request->getGet('thumb');
                if (isset($thumb)) {
                    $url .= '&thumb=' . $thumb;
                }
                $is_show_lightbox = $this->request->getGet('is_show_lightbox');
                if (isset($is_show_lightbox)) {
                    $data['is_show_lightbox'] = 1;
                    $url .= '&is_show_lightbox=1';
                }
                $file_type = $this->request->getGet('type');
                if (!empty($file_type)) {
                    $url .= '&type=' . $file_type;
                }

                $data['images'][] = [
                    'thumb' => '',
                    'name'  => implode(' ', $name),
                    'type'  => 'directory',
                    'path'  => substr($image, strlen($this->dir_image_path)),
                    'href'  => site_url('common/filemanager').'?directory=' .substr($image, strlen($this->dir_image_path . self::PATH_SUB_NAME . '/')) . $url,
                ];
            } elseif (is_file($image)) {
                $ext_tmp = explode('.', implode(' ', $name));
                $extension = end($ext_tmp);
                switch ($extension) {
                    case "jpg":
                    case "JPG":
                    case "jpeg":
                    case "JPEG":
                    case "gif":
                    case "GIF":
                    case "png":
                    case "PNG":
                    case "bmp":
                    case "BMP":
                    case "webp":
                    case "WEBP":
                    case "tiff":
                    case "TIFF":
                    case "raw":
                    case "RAW":
                    case "indd":
                    case "INDD":
                    case "heif":
                    case "HEIF":
                        $data['images'][] = [
                            'thumb' => image_url(substr($image, strlen($this->dir_image_path))) . '?' . time(),
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)) . '?' . time(),
                        ];
                        break;
                    case "svg":
                    case "SVG":
                    case "svgz":
                    case "SVGZ":
                        $data['images'][] = [
                            'thumb' => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)). '?' . time(),
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)) . '?' . time(),
                        ];
                        break;
                    case "pdf":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'far fa-file-pdf text-danger fa-5x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "html":
                    case "php":
                    case "js":
                    case "css":
                    case "txt":
                    case "md":
                    case "asp":
                    case "tpl":
                    case "aspx":
                    case "jsp":
                    case "py":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'far fa-file text-dark fa-4x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "apk":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'fab fa-android text-warning fa-4x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "webm":
                    case "WEBM":
                    case "mpg":
                    case "MPG":
                    case "mp2":
                    case "MP2":
                    case "mpeg":
                    case "MPEG":
                    case "mpe":
                    case "MPE":
                    case "mpv":
                    case "MPV":
                    case "ogg":
                    case "OGG":
                    case "mp4":
                    case "MP4":
                    case "m4p":
                    case "M4P":
                    case "m4v":
                    case "M4V":
                    case "avi":
                    case "AVI":
                    case "wmv":
                    case "WMV":
                    case "mov":
                    case "MOV":
                    case "qt":
                    case "QT":
                    case "flv":
                    case "FLV":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'video',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    default:
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convertFileSize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'fas fa-download text-secondary fa-4x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                }
            }
        }

        $data['heading_title'] = lang('FileManager.heading_title');

        $data['text_no_results'] = lang('Admin.text_no_results');
        $data['text_confirm']    = lang('Admin.text_confirm');

        $data['entry_search'] = lang('FileManager.entry_search');
        $data['entry_folder'] = lang('FileManager.entry_folder');

        $data['button_parent']  = lang('Admin.button_parent');
        $data['button_refresh'] = lang('Admin.button_refresh');
        $data['button_upload']  = lang('Admin.button_upload');
        $data['button_folder']  = lang('Admin.button_folder');
        $data['button_delete']  = lang('Admin.button_delete');
        $data['button_search']  = lang('Admin.button_search');

        $data['error_folder_null'] = lang('FileManager.error_folder_null');
        $data['error_file_null']   = lang('FileManager.error_file_null');
        $data['error_search_null'] = lang('FileManager.error_search_null');

        //$data['token'] = 'token';

        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $data['directory'] = urlencode($directory);
        } else {
            $data['directory'] = '';
        }


        $data['directory']   = !empty($this->request->getGet('directory')) ? urlencode($this->request->getGet('directory')) : "";
        $data['filter_name'] = $this->request->getGet('filter_name') ?? "";
        $data['target']      = $this->request->getGet('target') ?? ""; // Return the target ID for the file manager to set the value
        $data['thumb']       = $this->request->getGet('thumb') ?? ""; // Return the thumbnail for the file manager to show a thumbnail
        $data['file_type']   = $this->request->getGet('type') ?? "";

        // Parent
        $url = '';

        $directory = $this->request->getGet('directory');
        if (!empty($directory)) {
            $pos = strrpos($directory, '/');

            if ($pos) {
                $url .= '&directory=' . urlencode(substr($directory, 0, $pos));
            }
        }

        $target = $this->request->getGet('target');
        if (!empty($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->request->getGet('thumb');
        if (!empty($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $is_show_lightbox = $this->request->getGet('is_show_lightbox');
        if (!empty($is_show_lightbox)) {
            $data['is_show_lightbox'] = 1;
            $url .= '&is_show_lightbox=1';
        }

        $file_type = $this->request->getGet('type');
        if (!empty($file_type)) {
            $url .= '&type=' . $file_type;
        }

        $data['parent'] = site_url('common/filemanager').'?'. $url;

        // Refresh
        $url = '';

        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $url .= '&directory=' . urlencode($directory);
        }

        $target = $this->request->getGet('target');
        if (isset($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->request->getGet('thumb');
        if (isset($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $file_type = $this->request->getGet('type');
        if (!empty($file_type)) {
            $url .= '&type=' . $file_type;
        }

        $is_show_lightbox = $this->request->getGet('is_show_lightbox');
        if (isset($is_show_lightbox)) {
            $url .= '&is_show_lightbox=1';
        }

        $data['refresh'] = site_url('common/filemanager').'?'.$url;

        $url = '';

        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $url .= '&directory=' . urlencode(html_entity_decode($directory, ENT_QUOTES, 'UTF-8'));
        }

        $filter_name = $this->request->getGet('filter_name');
        if (isset($_GET['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
        }
        $target = $this->request->getGet('target');
        if (isset($target)) {
            $url .= '&target=' . $target;
        }
        $thumb = $this->request->getGet('thumb');
        if (isset($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $is_show_lightbox = $this->request->getGet('is_show_lightbox');
        if (isset($is_show_lightbox)) {
            $url .= '&is_show_lightbox=1';
        }

        $file_type = $this->request->getGet('type');
        if (!empty($file_type)) {
            $url .= '&type=' . $file_type;
        }

        $config['base_url']   = site_url('common/filemanager');
        $config['total_rows'] = $image_total;
        $config['per_page']   = self::FILE_PAGE_LIMIT;
        $config['page']       = $page;
        $config['url']        = $url;

        $data['pagination'] = $this->pagination($config);

        if ($this->request->isAJAX()) {
            $data['is_ajax'] = true;
            echo $this->themes::view('filemanager', $data);
        } else {
            $data['is_ajax'] = false;
            $this->themes->setTheme(config_item('theme_admin'))
                ->addPartial('header')
                ->addPartial('footer')
                ->addPartial('sidebar')
                ::load('filemanager', $data);
        }
    }

    public function upload()
    {
        try {

            $json = [];

            // create folder
            if (!is_dir($this->dir_image_path . self::PATH_SUB_NAME)) {
                mkdir($this->dir_image_path . self::PATH_SUB_NAME, 0777, true);
            }

            $directory = $this->request->getGet('directory');
            if (isset($directory)) {
                $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
            } else {
                $directory = $this->dir_image_path . self::PATH_SUB_NAME;
            }

            $file_name = 'file';
            $max_size = !empty(config_item('file_max_size')) ? config_item('file_max_size') : null;
            $max_width = !empty(config_item('file_max_width')) ? config_item('file_max_width') : null;
            $max_height = !empty(config_item('file_max_height')) ? config_item('file_max_height') : null;

            // Validation
            $validation = \Config\Services::validation();

            $valids = [
                sprintf('uploaded[%s]', $file_name),
                sprintf('ext_in[%s,%s]', $file_name, $this->upload_type),
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

            if ($validation->withRequest($this->request)->run() == FALSE) {
                json_output(['error' => $validation->getError($file_name)]);
            }

            if ($this->request->getFileMultiple($file_name)) {
                //if ($file->isValid() && !$file->hasMoved()) {
                foreach($this->request->getFileMultiple($file_name) as $file)
                {
                    // Get random file name
                    $newName = $file->getRandomName();
                    // Store file in public/uploads/ folder
                    $file->move($directory, $newName);

                    // File path to display preview
                    $filepath = $directory . $newName;

                    $json['success'] = lang('FileManager.text_uploaded');

                    if (!empty(config_item('enable_resize_image'))) {
                        $this->image_tool->resizeUpload($filepath);
                    }
                }
            } else {
                $json['error'] = lang('FileManager.error_upload');
            }

        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        json_output($json);
    }

    public function folder()
    {
        $json = [];

        // Make sure we have the correct directory
        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
        } else {
            $directory = $this->dir_image_path . self::PATH_SUB_NAME;
        }

        // Check its a directory
        if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) != $this->dir_image_path . self::PATH_SUB_NAME) {
            $json['error'] = lang('FileManager.error_directory');
        }


        if (!empty($this->request->getPost())) {
            // Sanitize the folder name
            $folder = basename(html_entity_decode($this->request->getPost('folder'), ENT_QUOTES, 'UTF-8'));

            $json['folder'] = $folder;
            // Validate the filename length
            if ((strlen($folder) < 3) || (strlen($folder) > 128)) {
                $json['error'] = lang('FileManager.error_folder');
            }

            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = lang('FileManager.error_exists');
            }
        }

        if (!isset($json['error'])) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);

            @touch($directory . '/' . $folder . '/' . 'index.html');

            $json['success'] = lang('FileManager.text_directory');
        }

        json_output($json);
    }

    public function delete()
    {
        $json = [];

        $path = $this->request->getPost('path');
        if (isset($path)) {
            $paths = $path;
        } else {
            $paths = [];
        }

        // Loop through each path to run validations
        foreach ($paths as $path) {
            // Check path exsists
            if ($path == $this->dir_image_path . self::PATH_SUB_NAME || substr(str_replace('\\', '/', realpath($this->dir_image_path . $path)), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) != $this->dir_image_path . self::PATH_SUB_NAME) {
                $json['error'] = lang('FileManager.error_delete');

                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim($this->dir_image_path . $path, '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);

                // If path is a directory beging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = [];

                    // Make path into an array
                    $path = [$path . '*'];

                    // While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            // If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

                            // Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

                    // Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
                        // If file just delete
                        if (is_file($file)) {
                            unlink($file);

                        // If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = lang('FileManager.text_delete');
        }

        json_output($json);
    }

    public function rotation($type = '90')
    {
        $json = [];

        $path = $this->request->getPost('path');
        // Check path exsists
        if (!is_file($this->dir_image_path . $path)) {
            $json['error'] = lang('FileManager.error_rotation');
        }

        if (!$json) {
            // Loop through each path
            $image = $this->image_tool->rotation($path, $type);

            if (!empty($image)) {
                $json['success'] = lang('FileManager.text_rotation');
                $json['image'] = image_url($image) . '?' . time();
            } else {
                $json['error'] = lang('FileManager.error_rotation');
            }
        }

        json_output($json);
    }

    public function pagination($data)
    {
        $base_url = $data['base_url'];
        $total    = $data['total_rows'];
        $per_page = $data['per_page'];
        $page     = $data['page'];
        $url      = $data['url'];
        $pages    = intval($total/$per_page); if($total%$per_page != 0){$pages++;}
        $p        = "";

        if ($pages > 1) {
            for($i=1; $i<= $pages; $i++){
                $p .= '<li class="page-item numlink"><a class="page-link directory" href="' . $base_url . '?page=' . $i . $url . '" >' . $i . '</a></li>';
            }
        }

        return $p;
    }

    private function _convertFileSize($bytes, $decimals = 2)
    {
        $size   = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
