<?php

namespace App\Modules\Common\Controllers;

use App\Controllers\AdminController;
use App\Libraries\Themes;

class FileManager extends AdminController
{
    protected $_image_tool;
    protected $_dir_image      = '';
    protected $_dir_image_path = '';
    protected $_file_url       = ''; // file/
    protected $_img_url        = ''; // img/

    protected $_upload_type = '';
    protected $_image_thumb_width  = '';
    protected $_image_thumb_height = '';

    public const PATH_SUB_NAME   = 'root';
    public const FILE_PAGE_LIMIT = 30;

    public const MANAGE_URL = 'common/filemanager';

    public function __construct()
    {
        parent::__construct();

        helper(['filesystem', 'number']);
        $this->_image_tool = new \App\Libraries\ImageTool();

        $this->request   = \Config\Services::request();
        $this->themes    = Themes::init();
        $this->validator = \Config\Services::validation();

        $this->_dir_image      = get_upload_url();
        $this->_dir_image_path = get_upload_path();

        $this->_upload_type = 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP,webp,WEBP,heic,HEIC,tiff,TIFF,svg,SVG,svgz,SVGZ,psd,PSD,raw,RAW,heif,HEIF,indd,INDD,ai,AI';
        if (!empty($this->request->getGet('type')) && in_array($this->request->getGet('type'), ["image", "media"])) {
            if ($this->request->getGet('type') == "image") {
                $this->_upload_type = 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,bmp,BMP,webp,WEBP,heic,HEIC,tiff,TIFF,svg,SVG,svgz,SVGZ,psd,PSD,raw,RAW,heif,HEIF,indd,INDD,ai,AI';
            } else {
                $this->_upload_type = 'webm,WEBM,mpg,MPG,mp2,MP2,mpeg,MPEG,mpe,MPE,mpv,MPV,ogg,OGG,mp4,MP4,m4p,M4P,m4v,M4V,avi,AVI,wmv,WMV,mov,MOV,qt,QT,flv,FLV,swf,SWF,avchd,AVCHD';
            }
        } elseif (!empty(config_item('file_ext_allowed'))) {
            $this->_upload_type = str_replace('|', ',', config_item('file_ext_allowed'));
        }

        $this->_image_thumb_width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
        $this->_image_thumb_height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;

        if (!is_dir($this->_dir_image_path . 'cache')) {
            mkdir($this->_dir_image_path . 'cache', 0777, true);
        }

        if (!is_dir($this->_dir_image_path . 'tmp')) {
            mkdir($this->_dir_image_path . 'tmp', 0777, true);
        }
    }

    public function index()
    {
        if (!$this->request->isAJAX()) {
            $this->smarty->assign('manage_url', self::MANAGE_URL);

            return $this->themes->setTheme(config_item('theme_admin'))
                ->addPartial('header')
                ->addPartial('footer')
                ->addPartial('sidebar')::load('index');
        }

        $server = site_url();

        $filter_name = $this->request->getGet('filter_name');
        if (!empty($filter_name)) {
            $filter_name = rtrim(str_replace('*', '', $filter_name), '/');
        } else {
            $filter_name = null;
        }

        $directory_session = null;

        // Make sure we have the correct directory
        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            session()->set('manager_directory', $directory);
            $directory = rtrim($this->_dir_image_path . self::PATH_SUB_NAME . '/' . str_replace('*', '', $directory), '/');
        } elseif (!empty(session('manager_directory')) && empty($this->request->getGet('is_parent'))) {
            $directory_session = session('manager_directory');
            $directory = rtrim($this->_dir_image_path . self::PATH_SUB_NAME . '/' . str_replace('*', '', $directory_session), '/');
            //session()->remove('manager_directory');
        } else {
            if (!empty($this->request->getGet('is_parent'))) {
                session()->remove('manager_directory');
            }
            $directory = $this->_dir_image_path . self::PATH_SUB_NAME;
        }

        $page = $this->request->getGet('page');
        if (isset($page)) {
            $page = $page;
        } else {
            $page = 1;
        }

        $directories = [];
        $files = [];

        $data['file_list'] = [];

        if (substr(str_replace('\\', '/', realpath($directory . '/')), 0, strlen($this->_dir_image_path . self::PATH_SUB_NAME)) == $this->_dir_image_path . self::PATH_SUB_NAME) {
            // Get directories
            $directories = glob($directory . '/*' . $filter_name . '*', GLOB_ONLYDIR);

            if (!$directories) {
                $directories = [];
            }

            $files = glob($directory . '/*' . $filter_name . '*.{' . $this->_upload_type . '}', GLOB_BRACE);

            if (!$files) {
                $files = [];
            }
        }

        $file_size = [];
        $file_tmp = [];
        foreach ($files as $key => $file) {
            $file_info = get_file_info($file);

            $file_size[$file]['size'] = !empty($file_info['size']) ? $file_info['size'] : 0;
            $file_size[$file]['date'] = !empty($file_info['date']) ? date("Y-m-d H:i:s", $file_info['date']) : null;

            $file_tmp[] = [
                'date' => $file_info['date'],
                'file' => $file
            ];
        }
        //usort($file_tmp, $this->_sortByDate('date'));

        $sort_key = array_keys($file_tmp);
        $sort_date = array_column($file_tmp, "date");
        array_multisort($sort_date, SORT_DESC, $sort_key, SORT_DESC, $file_tmp);

        foreach ($file_tmp as $key => $file) {
            $file_tmp[$key] = $file['file'];
        }
        // Merge directories and files
        $file_list = array_merge($directories, $file_tmp);

        // Get total number of files and directories
        $image_total = count($file_list);

        // Split the array based on current page number and max number of items per page of 10
        $file_list = array_splice($file_list, ($page - 1) * self::FILE_PAGE_LIMIT, self::FILE_PAGE_LIMIT);

        foreach ($file_list as $image) {
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
                $display = $this->request->getGet('d');
                if (!empty($display)) {
                    $url .= '&d=' . $display;
                }

                $data['file_list'][] = [
                    'thumb' => '',
                    'name'  => implode('', $name),
                    'type'  => 'directory',
                    'path'  => substr($image, strlen($this->_dir_image_path)),
                    'href'  => site_url('common/filemanager').'?directory=' . urlencode(substr($image, strlen($this->_dir_image_path . self::PATH_SUB_NAME . '/'))) . $url,
                ];
            } elseif (is_file($image)) {
                $ext_tmp = explode('.', implode('', $name));
                $extension = strtolower(end($ext_tmp));
                switch ($extension) {
                    case "jpg":
                    case "jpeg":
                    case "gif":
                    case "png":
                    case "bmp":
                    case "webp":
                    case "tiff":
                    case "raw":
                    case "indd":
                    case "heif":
                        $data['file_list'][] = [
                            'thumb' => image_root(substr($image, strlen($this->_dir_image_path))),
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'href'  => $server . $this->_img_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                        ];
                        break;
                    case "svg":
                    case "svgz":
                        $data['file_list'][] = [
                            'thumb' => $server . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'href'  => $server . $this->_img_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                        ];
                        break;
                    case "pdf":
                        $data['file_list'][] = [
                            'thumb' => '',
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'class' => 'far fa-file-pdf text-danger fa-5x',
                            'href'  => $server . $this->_file_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
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
                        $data['file_list'][] = [
                            'thumb' => '',
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'class' => 'far fa-file text-dark fa-4x',
                            'href'  => $server . $this->_file_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                        ];
                        break;
                    case "apk":
                        $data['file_list'][] = [
                            'thumb' => '',
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'class' => 'fab fa-android text-warning fa-4x',
                            'href'  => $server . $this->_file_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                        ];
                        break;
                    case "webm":
                    case "mpg":
                    case "mp2":
                    case "mpeg":
                    case "mpe":
                    case "mpv":
                    case "ogg":
                    case "mp4":
                    case "m4p":
                    case "m4v":
                    case "avi":
                    case "wmv":
                    case "mov":
                    case "qt":
                    case "flv":
                        $file_video = new \CodeIgniter\Files\File($image);
                        $data['file_list'][] = [
                            'thumb' => '',
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'ext'   => $file_video->getMimeType(),
                            'type'  => 'video',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'class' => 'fas fa-film text-dark fa-4x',
                            'href'  => $server . $this->_file_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
                        ];
                        break;
                    default:
                        $data['file_list'][] = [
                            'thumb' => '',
                            'name'  => implode('', $name),
                            'size'  => number_to_size($file_size[$image]['size']),
                            'date'  => $file_size[$image]['date'],
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->_dir_image_path)),
                            'class' => 'fas fa-download text-secondary fa-4x',
                            'href'  => $server . $this->_file_url . $this->_dir_image . substr($image, strlen($this->_dir_image_path)),
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
        $data['entry_upload_url'] = lang('FileManager.entry_upload_url');

        $data['button_parent']  = lang('Admin.button_parent');
        $data['button_refresh'] = lang('Admin.button_refresh');
        $data['button_upload']  = lang('Admin.button_upload');
        $data['button_upload_device']  = lang('FileManager.button_upload_device');
        $data['button_upload_url']  = lang('FileManager.button_upload_url');
        $data['button_folder']  = lang('Admin.button_folder');
        $data['button_delete']  = lang('Admin.button_delete');
        $data['button_search']  = lang('Admin.button_search');

        $data['error_folder_null'] = lang('FileManager.error_folder_null');
        $data['error_file_null']   = lang('FileManager.error_file_null');
        $data['error_search_null'] = lang('FileManager.error_search_null');

        //$data['token'] = 'token';

        $directory = !empty($directory_session) ? $directory_session : $this->request->getGet('directory');
        if (!empty($directory)) {
            $data['directory'] = urlencode($directory);
        } else {
            $data['directory'] = '';
        }

        //$data['directory']   = !empty($this->request->getGet('directory')) ? urlencode($this->request->getGet('directory')) : "";
        $data['input_upload_from_url'] = $this->request->getGet('input_upload_from_url') ?? "";
        $data['filter_name']           = $this->request->getGet('filter_name') ?? "";
        $data['target']                = $this->request->getGet('target') ?? ""; // Return the target ID for the file manager to set the value
        $data['thumb']                 = $this->request->getGet('thumb') ?? ""; // Return the thumbnail for the file manager to show a thumbnail
        $data['file_type']             = $this->request->getGet('type') ?? "";
        $data['display']               = empty($this->request->getGet("d")) ? DISPLAY_GRID : $this->request->getGet("d");

        // Parent
        $url = '';

        $directory = !empty($directory_session) ? $directory_session : $this->request->getGet('directory');
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
        $display = $this->request->getGet('d');
        if (!empty($display)) {
            $url .= '&d=' . $display;
        }
        $url .= '&is_parent=1';
        $data['parent'] = site_url('common/filemanager').'?'. $url;

        // Refresh
        $url = '';

        $directory = !empty($directory_session) ? $directory_session : $this->request->getGet('directory');
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
        $display = $this->request->getGet('d');
        if (!empty($display)) {
            $url .= '&d=' . $display;
        }

        $data['refresh'] = site_url('common/filemanager').'?' . $url;

        // Display
        $url = '';
        $directory = !empty($directory_session) ? $directory_session : $this->request->getGet('directory');
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
        $data['display_url'] = site_url('common/filemanager').'?' . $url;

        //
        $url = '';

        $directory = !empty($directory_session) ? $directory_session : $this->request->getGet('directory');
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
        $display = $this->request->getGet('d');
        if (!empty($display)) {
            $url .= '&d=' . $display;
        }

        $config['base_url']   = site_url('common/filemanager');
        $config['total_rows'] = $image_total;
        $config['per_page']   = self::FILE_PAGE_LIMIT;
        $config['page']       = $page;
        $config['url']        = $url;

        $data['pagination'] = $this->pagination($config);

        $data['file_max_size'] = number_to_size(config_item('file_max_size') * 1024);

        $data['is_ajax'] = true;
        echo $this->themes::view('filemanager', $data);
    }

    public function upload()
    {
        try {

            $json = [];

            // create folder
            if (!is_dir($this->_dir_image_path . self::PATH_SUB_NAME)) {
                mkdir($this->_dir_image_path . self::PATH_SUB_NAME, 0777, true);
            }

            $directory = $this->request->getGet('directory');
            if (isset($directory)) {
                $directory = rtrim($this->_dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
            } else {
                $directory = $this->_dir_image_path . self::PATH_SUB_NAME;
            }

            $file_name  = 'file';
            $max_size   = !empty(config_item('file_max_size')) ? config_item('file_max_size') : null;
            $max_width  = !empty(config_item('file_max_width')) ? config_item('file_max_width') : null;
            $max_height = !empty(config_item('file_max_height')) ? config_item('file_max_height') : null;

            // Validation
            $validation = \Config\Services::validation();

            $valids = [
                sprintf('uploaded[%s]', $file_name),
                sprintf('ext_in[%s,%s]', $file_name, $this->_upload_type),
            ];

            if (!empty($max_size)) {
                $valids[] = sprintf('max_size[%s,%s]', $file_name, $max_size);
            }

            if (!empty($max_width) && !empty($max_height)) {
                $valids[] = sprintf('max_dims[%s,%d,%d]', $file_name, $max_width, $max_height);
            }

            $validation->setRules([
                $file_name => $valids
            ]);

            if ($validation->withRequest($this->request)->run() == false) {
                json_output(['error' => $validation->getError($file_name)]);
            }

            if ($this->request->getFileMultiple($file_name)) {
                //if ($file->isValid() && !$file->hasMoved()) {
                foreach ($this->request->getFileMultiple($file_name) as $file) {
                    // Get random file name
                    $newName = !empty(config_item('file_encrypt_name')) ? trim($file->getRandomName()) : str_replace(" ", "", trim($file->getName()));
                    if (preg_match('/\A[a-z 0-9~%.:_\-]+\z/iu', $newName) !== 1) {
                        $newName = $file->getRandomName();
                    }

                    // Store file in public/uploads/ folder
                    $file->move($directory, $newName);

                    // File path to display preview
                    $filepath = $directory . $newName;

                    $json['success'] = lang('FileManager.text_uploaded');

                    if (!empty(config_item('enable_resize_image'))) {
                        $this->_image_tool->resizeUpload($filepath);
                    }
                    usleep(1000);
                }
            } else {
                $json['error'] = lang('FileManager.error_upload');
            }

        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        json_output($json);
    }

    public function uploadUrl()
    {
        $json = [];

        // create folder
        if (!is_dir($this->_dir_image_path . self::PATH_SUB_NAME)) {
            mkdir($this->_dir_image_path . self::PATH_SUB_NAME, 0777, true);
        }

        // Make sure we have the correct directory
        $directory = $this->request->getGet('directory');
        if (isset($directory)) {
            $directory = rtrim($this->_dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
        } else {
            $directory = $this->_dir_image_path . self::PATH_SUB_NAME;
        }

        try {
            if (!empty($this->request->getPost())) {

                // Sanitize the folder name
                $url = $this->request->getPost('url');

                $url_parts = pathinfo($url);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                $response = curl_exec($ch);
                curl_close($ch);

                $file_new = $url_parts['filename'] . '.' . $url_parts['extension'];
                file_put_contents($directory . '/' . $file_new, $response);

                if (!empty(config_item('enable_resize_image'))) {
                    $this->_image_tool->resizeUpload($directory . '/' . $file_new);
                }

                $json['success'] = lang('FileManager.text_uploaded');
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
            $directory = rtrim($this->_dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
        } else {
            $directory = $this->_dir_image_path . self::PATH_SUB_NAME;
        }

        // Check its a directory
        if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen($this->_dir_image_path . self::PATH_SUB_NAME)) != $this->_dir_image_path . self::PATH_SUB_NAME) {
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
            if ($path == $this->_dir_image_path . self::PATH_SUB_NAME || substr(str_replace('\\', '/', realpath($this->_dir_image_path . $path)), 0, strlen($this->_dir_image_path . self::PATH_SUB_NAME)) != $this->_dir_image_path . self::PATH_SUB_NAME) {
                $json['error'] = lang('FileManager.error_delete');
                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim($this->_dir_image_path . $path, '/');

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
        if (!is_file($this->_dir_image_path . $path)) {
            $json['error'] = lang('FileManager.error_rotation');
        }

        if (empty($json)) {
            // Loop through each path
            $image = $this->_image_tool->rotation($path, $type);

            if (!empty($image)) {
                $json['success'] = lang('FileManager.text_rotation');
                $json['image'] = image_root($image) . '?' . time();
            } else {
                $json['error'] = !empty($this->_image_tool->getError()) ? $this->_image_tool->getError() : lang('FileManager.error_rotation');
            }
        }

        json_output($json);
    }

    public function clearCache()
    {
        $json = [];

        try {
            delete_cache();

            $json['success'] = lang('FileManager.text_clear_cache_success');
        } catch (Exception $e) {
            $json['error'] = lang('Admin.error');
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
        $pages    = intval($total / $per_page);

        if ($total % $per_page != 0) {
            $pages++;
        }

        $p        = "";
        if ($pages > 1) {
            for ($i = 1; $i <= $pages; $i++) {
                $p .= ($page == $i) ? '<li class="page-item numlink active">' : '<li class="page-item numlink">';
                $p .= '<a class="page-link directory" href="' . $base_url . '?page=' . $i . $url . '" >' . $i . '</a></li>';
            }
        }

        return $p;
    }

    private function _convertFileSize($bytes, $decimals = 2)
    {
        $size   = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    private function _sortByDate($key)
    {
        return function ($a, $b) use ($key) {
            return strtotime($b[$key]) <=> strtotime($a[$key]);
        };
    }
}
