<?php

namespace App\Libraries;

include_once("SimpleHtmlDom.php");

class H_Crawl
{
    var $html_content = '';
    var $arr_att_clean = array();

    public function __construct()
    {
        // nothing to do
    }

    public function getTitle($link, $att_title){
        if($this->html_content==''){
            $html = file_get_html($link);
            $this->html_content = $html;    
        }else{
            $html = $this->html_content;
        }
        foreach($html->find($att_title) as $e){
            $title = $e->innertext;
        }
        return $title;
    }

    public function runBrowser($url) {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            $response = @file_get_contents($url);
        }

        return $response;
    }

    public function getContent($link, $att_content){
        if($this->html_content==''){
            $html = file_get_html($link);
            $this->html_content = $html;    
        }else{
            $html = $this->html_content;
        }
                
        foreach($html->find($att_content) as $e){
            $content_html = $e->innertext;
        }
        $html = str_get_html($content_html);
       
        foreach($this->arr_att_clean as $att_clean){
            // google+
            foreach($html->find($att_clean) as $e){
                $e->outertext = '';
            }
        }
        
        $ret = $html->save();
        return $ret;
    }

    public function removeLink($content){
        $html = str_get_html($content);
        // link content
        foreach($html->find('a') as $e){
            $e->outertext = $e->innertext;
        }
        $ret = $html->save();
        return $ret;
    }

    public function removeLastElement($content, $element){
        $html = str_get_html($content);
        // link content
        $html->find($element, -1)->outertext = '';
        $ret = $html->save();
        return $ret;
    }

    public function removeFirstElement($content, $element){
        $html = str_get_html($content);        
        $html->find($element, 0)->outertext = '';
        $ret = $html->save();
        return $ret;
    }
}
