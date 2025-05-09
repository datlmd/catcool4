<?php

namespace App\Modules\Images\Controllers;

use App\Controllers\MyController;

class File extends MyController
{
    private $_file_path;
    private $_file_url;

    private $_type_video = 'webm,WEBM,mpg,MPG,mp2,MP2,mpeg,MPEG,mpe,MPE,mpv,MPV,ogg,OGG,mp4,MP4,m4p,M4P,m4v,M4V,avi,AVI,wmv,WMV,mov,MOV,qt,QT,flv,FLV,swf,SWF,avchd,AVCHD';

    public function __construct()
    {
        parent::__construct();

        helper('filesystem');

        $this->_file_path = get_upload_path();
        $this->_file_url  = get_upload_url();
    }

    public function index()
    {
        try {
            $file_url = str_replace([base_url('file/'), UPLOAD_FILE_DIR], ['', ''], current_url());
            $file_url = urldecode($file_url);

            if (!is_file($this->_file_path . $file_url)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $this->_rangeVideo($this->_file_path . $file_url);
            /*
            $file_info = new \CodeIgniter\Files\File($this->_file_path . $file_url);
            $this->response
                ->setStatusCode(200)
                ->setContentType($file_info->getMimeType())
                ->setBody(file_get_contents($this->_file_path . $file_url))
                ->download($this->_file_path . $file_url)
                ->send();
            */
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            //die($e->getMessage());
        }
    }

    private function _rangeVideo($file)
    {
        $file_info = new \CodeIgniter\Files\File($file);

        $fp = @fopen($file, 'rb');

        $size   = filesize($file); // File size
        $length = $size;           // Content length
        $start  = 0;               // Start byte
        $end    = $size - 1;       // End byte

        header("Content-type: " . $file_info->getMimeType());
        header("Accept-Ranges: 0-$length");
        if (isset($_SERVER['HTTP_RANGE'])) {

            $c_start = $start;
            $c_end   = $end;

            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            } else {
                $range  = explode('-', $range);
                $c_start = $range[0];
                $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            $c_end = ($c_end > $end) ? $end : $c_end;
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            $start  = $c_start;
            $end    = $c_end;
            $length = $end - $start + 1;
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }

        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: ".$length);
        //helper("Content-Disposition: attachment;");

        $buffer = 1024 * 8;
        while (!feof($fp) && ($p = ftell($fp)) <= $end) {

            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            set_time_limit(0);
            echo fread($fp, $buffer);
            flush();
        }

        fclose($fp);
        exit();
    }
}
