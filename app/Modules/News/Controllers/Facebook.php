<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\NewsModel;
use CodeIgniter\Controller;

class Facebook extends Controller
{
    protected $model;

    protected $helpers = ['url', 'date', 'catcool', 'inflector'];

    public const SITEMAP_NEWS_FROM = '2021-06-01';

    public function __construct()
    {
        $this->model = new NewsModel();

        date_default_timezone_set('Asia/Saigon');
    }

    public function index()
    {
        try {
            header('Content-Type: application/rss+xml; charset=ISO-8859-1');

            $from_date = date('Y-m-d H:i:s', strtotime('-14 day', time()));
            $to_date = get_date();

            //add news
            $where = [
                'published' => STATUS_ON,
                //'publish_date >=' => $from_date,
                'publish_date <=' => $to_date,
            ];
            $news_list = $this->model
                ->select('news_id, slug, name, description, content, images, publish_date, created_at, updated_at')
                ->orderBy('news_id', 'desc')
                ->where($where)
                ->findAll(10);

            $rssfeed = '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">';
            $rssfeed .= '<channel>';
            $rssfeed .= '<title>'.config_item('site_name').'</title>';
            $rssfeed .= '<link>'.site_url().'</link>';
            $rssfeed .= '<description>'.config_item('site_description').'</description>';
            $rssfeed .= '<language>vi</language>';
            $rssfeed .= '<copyright>Copyright (C) '.date('Y').' loitraitim.vn</copyright>';

            if (!empty($news_list)) {
                foreach ($news_list as $key => $value) {
                    $value = $this->model->formatDetail($value);

                    $thumbnail = '';
                    if (!empty($value['images']['thumb'])) {
                        $thumbnail = image_url($value['images']['thumb'], 200, 130);
                    } else {
                        $thumbnail = $value['images']['robot'];
                    }

                    $rssfeed .= '<item>';
                    $rssfeed .= '<title>'.$value['name'].'</title>';
                    $rssfeed .= '<description>'.$value['description'].'</description>';
                    $rssfeed .= '<guid>1</guid>';

                    // Replace URL according to website url patterns
                    $rssfeed .= '<link>'.base_url($value['detail_url']).'</link>';

                    $rssfeed .= '<pubDate>'.date('D, d M Y H:i:s O', strtotime($value['publish_date'])).'</pubDate>';
                    $rssfeed .= '<author>Ryan Lee</author>';

                    // Here is the link https://developers.facebook.com/docs/instant-articles/example-articles which explains the differen options for content body
                    $rssfeed .= '<content:encoded>';
                    $rssfeed .= '<![CDATA[';
                    $rssfeed .= '<!doctype html>';
                    $rssfeed .= '<html lang="en" prefix="op: http://media.facebook.com/op#">';
                    $rssfeed .= '<head>';
                    $rssfeed .= '<meta charset="utf-8">';
                    $rssfeed .= '<link rel="canonical" href="'.base_url($value['detail_url']).'">';
                    $rssfeed .= '<meta property="op:markup_version" content="v1.0">';
                    $rssfeed .= '<meta property="og:title" content="'.$value['name'].'">';
                    $rssfeed .= '<meta property="og:description" content="'.$value['name'].'">';
                    $rssfeed .= '<meta property="og:image" content="'.$thumbnail.'">';
                    $rssfeed .= '</head>';
                    $rssfeed .= '<body>';
                    $rssfeed .= '<article>';
                    $rssfeed .= '<header>';
                    $rssfeed .= '<h1>'.$value['name'].'</h1>';
                    $rssfeed .= '<time class="op-published" datetime="'.date('D, d M Y H:i:s O', strtotime($value['publish_date'])).'">'.date('D, d M Y H:i:s O', strtotime($value['publish_date'])).'</time>';
                    $rssfeed .= '<time class="op-modified" dateTime="'.date('D, d M Y H:i:s O', strtotime($value['updated_at'])).'">'.date('D, d M Y H:i:s O', strtotime($value['updated_at'])).'</time>';

                    /*
                    $rssfeed .= '<address>';
                    $rssfeed .= '<a rel="facebook" href="https://www.facebook.com/yourwebsite.org">Video Lime</a>';
                    $rssfeed .= 'Enjoy the videos and music you love, original content and share it all with friends, family and the world on YouTube.';
                    $rssfeed .= '</address>';
                    $rssfeed .= '<address>';
                    $rssfeed .= '<a>Video Lime</a>';
                    $rssfeed .= '</address>';

                    $rssfeed .= '<figure>';
                    // Change URL according to website url patterns
                    $rssfeed .= '<img src="http://yourwebsite.org/upload/videos/'.$thumbnail.'" />';
                    $rssfeed .= '<figcaption>' . $title . '</figcaption>';
                    $rssfeed .= '</figure>';
                    */

                    $rssfeed .= '</header>';
                    $rssfeed .= '<p> '.$value['content'].' </p>';

                    //                    // Optional :  please reveiw Guide line https://developers.facebook.com/docs/instant-articles/reference/embeds
                    //                    $rssfeed .= '<figure class="op-interactive">';
                    //                    $rssfeed .= '<iframe class="column-width" height="180" width="320" src="https://www.youtube.com/embed/'.$youtube_id.'"></iframe>';
                    //
                    //                    $rssfeed .= '<figcaption>' . $title . '</figcaption>';
                    //                    $rssfeed .= '</figure>';

                    $rssfeed .= '<footer>';
                    $rssfeed .= '<aside>Managed By loitraitim.vn</aside>';
                    $rssfeed .= '<small>Copyright (C) '.date('Y').' loitraitim.vn</small>';
                    $rssfeed .= '</footer>';
                    $rssfeed .= '</article>';
                    $rssfeed .= '</body>';
                    $rssfeed .= '</html>';
                    $rssfeed .= ']]>';
                    $rssfeed .= '</content:encoded>';
                    $rssfeed .= '</item>';
                }
            }

            $rssfeed .= '</channel>';
            $rssfeed .= '</rss>';

            echo $rssfeed;
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            $this->pageNotFound();
        }
    }
}
