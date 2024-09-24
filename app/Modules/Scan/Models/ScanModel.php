<?php

namespace App\Modules\Scan\Models;

use App\Models\MyModel;
use Exception;

class ScanModel extends MyModel
{
    protected $table = '';
    protected $primaryKey = '';

    protected $returnType = 'array';
    private $_html_content = "";

    private $_domain_content = [
        'vzn.vn' => ["ftwp-postcontent", "!--End:Text Content--"], //cat html giua 2 vi tri duoc danh dau
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function scanUrl(string $url)
    {
        if (empty($url)) {
            return [];
        }

        $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
        $domain = strtolower($domain);
        
        $content = $this->getUrlData($url);

        return $content;
    }

    public function getUrlData($url)
    {
        $contents = $this->getUrlContents($url);
        if (empty($contents)) {
            return null;
        }
        
        $title = null;
        $meta_tags = [];

        preg_match('/<title>([^>]*)<\/title>/si', $contents, $match);
        if (isset($match) && is_array($match) && count($match) > 0) {
            $title = $match[1];
        }

        preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

        if (isset($match) && is_array($match) && count($match) == 3) {
            $originals = $match[0];
            $names = $match[1];
            $values = $match[2];

            if (count($originals) == count($names) && count($names) == count($values)) {
                for ($i = 0, $limiti = count($names); $i < $limiti; $i++) {
                    if (strpos($names[$i], 'image') !== false && strpos($originals[$i], '.') !== false) {
                        $meta_tags['image'] = [
                            'html' => htmlentities($originals[$i]),
                            'value' => $values[$i]
                        ];
                    } else {
                        $meta_tags[$names[$i]] = [
                            'html' => htmlentities($originals[$i]),
                            'value' => $values[$i]
                        ];
                    }
                }
            }
        }

        preg_match_all('/<[\s]*meta[\s]*property="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

        if (isset($match) && is_array($match) && count($match) == 3) {
            $originals = $match[0];
            $names = $match[1];
            $values = $match[2];

            if (count($originals) == count($names) && count($names) == count($values)) {
                for ($i = 0, $limiti = count($names); $i < $limiti; $i++) {
                    if (strpos($names[$i], 'image') !== false && strpos($originals[$i], '.') !== false) {
                        $meta_tags['image'] = [
                            'html' => htmlentities($originals[$i]),
                            'value' => $values[$i]
                        ];
                    } else {
                        $meta_tags[$names[$i]] = [
                            'html' => htmlentities($originals[$i]),
                            'value' => $values[$i]
                        ];
                    }
                }
            }
        }

        preg_match("/<body[^>]*>(.*?)<\/body>/is", $contents, $match);
        if (isset($match) && is_array($match) && count($match) > 0) {
            $contents = $match[1];
        }
        
        //lay noi dung chinh
        $domain = get_domain($url);
        $content_temp = substr($contents, strpos($contents, substr($title, 0, 20)), strlen($contents));
        if (!empty($this->_domain_content[$domain])) {
            $content_temp = substr($contents, strpos($contents, $this->_domain_content[$domain][0]), strlen($contents));
            $content_temp = substr($content_temp, 0, strpos($content_temp, $this->_domain_content[$domain][1]));
        }

        $contents = $content_temp;
        $images = $this->getListImage($contents);

        $contents = strip_tags($contents, "<strong>><i><b><br><p><h1><h2><h3><h4><h5><h6><img><ul><li><table><span>");

        foreach ($images as $iamge) {
            if (empty($iamge)) {
                continue;
            }
            $contents .= '<img src="' . $iamge . '" />';
        }

        return [
            'title' => html_entity_decode(strip_tags($title)),
            'content' => $contents,
            'meta' => $meta_tags
        ];
    }

    public function getListImage($content)
    {
        $images = [];
        if (empty($content)) {
            return [];
        }

        try {
            $bool = true;
            $i = 0;

            $start = '<img';
            $end = '>';

            $content = str_ireplace("'", '"', $content);

            do {

                $p_start = 0;
                $p_end = 0;
                $p_start = strpos($content, $start, $p_start);

                if ($p_start !== false) {
                    $p_end = strpos($content, $end, $p_start);

                    if ($p_end > 0) {
                        $temp = substr($content, $p_start, $p_end - $p_start);

                        $content = substr($content, $p_end, strlen($content) - 1);

                        $href = $img = $title = $note = $date = '';

                        preg_match('/src=\"(.*?)\"/', $temp, $matches);
                        if ($matches) {
                            $images[$matches[1]] = $matches[1];
                        }

                        preg_match('/data-original=\"(.*?)\"/', $temp, $matches);
                        if ($matches) {
                            $images[$matches[1]] = $matches[1];
                        }

                        preg_match('/data-src=\"(.*?)\"/', $temp, $matches);
                        if ($matches) {
                            $images[$matches[1]] = $matches[1];
                        }

                        preg_match('/background-image:url\"(.*?)\"/', $temp, $matches);
                        if ($matches) {
                            $images[$matches[1]] = $matches[1];
                        }
                    }
                } else {
                    $bool = false;
                }
            } while ($bool);
        } catch (Exception $e) {
            return [];
        }

        return $images;
    }

    public function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
    {
        if (!empty($this->_html_content)) {
            return $this->_html_content;
        }

        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            $contents = curl_exec($ch);
            curl_close($ch);
        } else {
            $contents = @file_get_contents($url);

            // Check if we need to go somewhere else
            if (isset($contents) && is_string($contents)) {
                preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

                if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1) {
                    if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections) {
                        return $this->getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                    }
                }
            }
        }

        $contents = str_ireplace("href =", "href=", $contents);
        $contents = str_ireplace("href= ", "href=", $contents);
        $contents = str_ireplace(['background-image: url', 'background-image :url'], ['background-image:url', 'background-image:url'], $contents);
        $contents = str_ireplace("background-image:url(", "src=", $contents);
        $contents = str_ireplace("ata-background-image=", "src=", $contents);

        $this->_html_content = $contents;

        return $contents;
    }
}
