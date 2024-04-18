<?php namespace App\Modules\Tools\Controllers;

use App\Controllers\MyController;

class Youtube extends MyController
{
    protected $errors = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        //META
        $data_meta = [
            'title'          => lang('Tool.text_youtube_download_meta_title'),
            'description'    => lang('Tool.text_youtube_download_meta_description'),
            'keywords'       => lang('Tool.text_youtube_download_meta_keyword'),
            'url'            => current_url(),
        ];
        add_meta($data_meta, $this->themes);

        $this->themes
            ->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom')
            ::load('youtube_download');
    }

    public function apiYoutubeVideo()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $error_message = "";

        if (empty($this->request->getGet('url'))) {
            $error_message = lang('Tool.error_youtube_download');
        }

        try {

            $video_link = $this->request->getGet('url');

            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_link, $match);
            if (!empty($match[1]) && empty($error_message)) {
                $video_id = $match[1];

                $video_data = $this->getYoutubeVideoMeta($video_id);
                $video_data = json_decode($video_data, true);

                $video_list = [];
                foreach ($video_data['streamingData']['formats'] as $value) {
                    if (empty($value['url'])) {
                        continue;
                    }

                    $type = !empty($value['mimeType']) ? explode(";", explode("/", $value['mimeType'])[1])[0] : 'mp4';

                    $video_list['video_top_list'][] = [
                        'type' => $type,
                        'url' => $value['url'],
                        'download_url' => 'tools/youtube/huong-dan-tai?link=' . urlencode($value['url']) . '&title=' . urlencode($video_data['videoDetails']['title']) . '&type=' . $type,
                        'qualityLabel' => $value['qualityLabel'] ?? "",
                    ];
                }

                foreach ($video_data['streamingData']['adaptiveFormats'] as $value) {
                    if (empty($value['url']) || empty($value['qualityLabel'])) {
                        continue;
                    }

                    $type = !empty($value['mimeType']) ? explode(";", explode("/", $value['mimeType'])[1])[0] : 'mp4';

                    $video_list['video_all'][] = [
                        'type' => $type,
                        'url' => $value['url'],
                        'download_url' => 'tools/youtube/huong-dan-tai?link=' . urlencode($value['url']) . '&title=' . urlencode($video_data['videoDetails']['title']) . '&type=' . $type,
                        'qualityLabel' => $value['qualityLabel'] ?? "",
                    ];
                }

                $data = [
                    'video_info' => $video_data['videoDetails'],
                    'video_list' => $video_list
                ];
            } else {
                $error_message = lang('Tool.error_youtube_download');
            }
        } catch (\Exception $ex) {
            $error_message = $ex->getMessage();
        }

        $data['error_message'] = $error_message;

        echo $this->themes
            ::view('api/youtube_download', $data);
    }

    public function download()
    {
        $downloadURL = urldecode($this->request->getGet('link'));
        $downloadFileName = urldecode($this->request->getGet('title')) . '.' . urldecode($this->request->getGet('type'));
        if (! empty($downloadURL) && substr($downloadURL, 0, 8) === 'https://') {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment;filename=\"$downloadFileName\"");
            header("Content-Transfer-Encoding: binary");
            readfile($downloadURL);
        }
    }

    public function getYoutubeVideoMeta($videoId, $key = null)
    {
        $key = $key ?? 'AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8';

        $ch = curl_init();
        $curlUrl = 'https://www.youtube.com/youtubei/v1/player?key=' . $key;
        curl_setopt($ch, CURLOPT_URL, $curlUrl);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $curlOptions = '{"context": {"client": {"hl": "en","clientName": "WEB",
        "clientVersion": "2.20210721.00.00","clientFormFactor": "UNKNOWN_FORM_FACTOR","clientScreen": "WATCH",
        "mainAppWebInfo": {"graftUrl": "/watch?v=' . $videoId . '",}},"user": {"lockedSafetyMode": false},
        "request": {"useSsl": true,"internalExperimentFlags": [],"consistencyTokenJars": []}},
        "videoId": "' . $videoId . '",  "playbackContext": {"contentPlaybackContext":
        {"vis": 0,"splay": false,"autoCaptionsDefaultOn": false,
        "autonavState": "STATE_NONE","html5Preference": "HTML5_PREF_WANTS","lactMilliseconds": "-1"}},
        "racyCheckOk": false,  "contentCheckOk": false}';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlOptions);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $curlResult = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $curlResult;
    }
}
