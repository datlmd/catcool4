<?php namespace App\Libraries;

class Fba
{
    private $path = null;

    public function __construct()
    {

    }

    // funsi ini untuk mendapatkan jumlah item dalam sebuah folder
    private function _item($dir)
    {
        $files = [];

        if(scandir($dir)){
            foreach(scandir($dir) as $f) {
                if(!$f || $f[0] == '.') {
                    continue; // Abaikan file tersembunyi
                }
                $files[] = [
                    "name" => $f
                ];
            }
        }

        return $files;
    }

    public function setPath($path = null)
    {
        $this->path = empty($path) ? 'public/themes' : $path;
        return true;
    }

    // Fungsi ini untuk melihat isi folder
    public function scan($path = null)
    {
        $files = [];

        if(preg_match('/\.\./', $path)){
            $path = '';
        }

        $files['status'] = 'success';

        $browser = (empty($path) ? ROOTPATH . $this->path : ROOTPATH . $this->path . '/' .$path);

        // Apakah benar-benar terdapat folder/file?
        if(file_exists($browser)){

            $files['status'] = 'success';

            foreach(scandir($browser) as $f) {

                if(!$f || $f[0] == '.') {
                    continue; // Abaikan file tersembunyi
                }

                if(is_dir($browser . '/' . $f)) {
                    // List folder
                    $files['data'][] = [
                        "name"  => $f,
                        "type"  => "dir",
                        "modif" => date('Y-m-d h:i:s',filemtime($browser . '/' . $f)),
                        "path"  => (empty($path) ? $f : $path . '/' .$f),
                        "items" => count($this->_item($browser . '/' . $f)) // Menscan lagi isi folder
                    ];
                }

                else {
                    // List file
                    $files['data'][] = [
                        "name"  => $f,
                        "type"  => "file",
                        "dir"   => $this->path,
                        "path"  => (empty($path) ? $f : $path . '/' .$f),
                        "modif" => date('Y-m-d h:i:s',filemtime($browser . '/' . $f)),
                        "size"  => filesize($browser . '/' . $f) // Mendapatkan ukuran file
                    ];
                }
            }

        } else {
            $files['status'] = 'error';
        }

        return $files;
    }

    // funsi ini untuk melihat isi file
    public function read($file)
    {
        if (preg_match('/\.\./', $file)) {
            return ['status' => 'error'];
        } else {

            $browser = (empty($file) ? ROOTPATH . $this->path : ROOTPATH . $this->path . '/' . $file);
            if (!is_file($browser)) {
                return ['status' => 'error'];
            }

            $text  = file_get_contents($browser);
            $perms = substr(decoct(fileperms($browser)), -4);

            return ['status' => 'success', 'text' => $text, 'perms' => $perms];

        }
    }

    public function write($file, $content)
    {
        if (preg_match('/\.\./', $file)) {
            return ['status' => 'error'];
        } else {
            $browser = ROOTPATH . $this->path . '/' . $file;
            if (!is_file($browser)) {
                return ['status' => 'error'];
            }

            helper('filesystem');

            write_file($browser, $content);

            return ['status' => 'success'];
        }
    }
}
