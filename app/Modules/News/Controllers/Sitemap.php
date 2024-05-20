<?php

namespace App\Modules\News\Controllers;

use App\Libraries\LibSitemap;
use App\Modules\News\Models\CategoryModel;
use App\Modules\News\Models\NewsModel;
use CodeIgniter\Controller;

class Sitemap extends Controller
{
    protected $model;

    protected $helpers = ['url', 'date', 'catcool', 'inflector'];

    const SITEMAP_NEWS_FROM = '2021-06-01';

    public function __construct()
    {
        $this->model = new NewsModel();

        $this->libsitemap = new LibSitemap();

        date_default_timezone_set('Asia/Saigon');
    }

    public function index()
    {
        try {
            $this->libsitemap->add(base_url('sitemap-category.xml'), date('c', time()));
            $this->libsitemap->add(base_url('sitemap-news.xml'), date('c', time()));

            $news_start = strtotime(self::SITEMAP_NEWS_FROM);
            $news_end = time();
            while ($news_end > $news_start) {
                $new_month = sprintf('sitemap-news-%s.xml', date('Ym', $news_end));
                $this->libsitemap->add(base_url($new_month), date('c', time()));

                $news_end = strtotime('-1 month', $news_end);
            }

            $post_start = strtotime(self::SITEMAP_NEWS_FROM);
            $post_end = time();
            while ($post_end > $post_start) {
                $new_year = sprintf('sitemap-post-%s.xml', date('Y', $post_end));
                $this->libsitemap->add(base_url($new_year), date('c', time()));

                $post_end = strtotime('-1 year', $post_end);
            }

            $x = $this->libsitemap->output('sitemapindex', 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"');

            $this->response
                ->setXML($x)
                ->send();
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            page_not_found();
        }
    }

    public function news($month = null)
    {
        try {
            if (!empty($month)) {
                $month = $month.'01';
                $from_date = date('Y-m-01 00:00:00', strtotime($month));
                $to_date = date('Y-m-t 23:59:59', strtotime($month));
            } else {
                $from_date = date('Y-m-d H:i:s', strtotime('-14 day', time()));
                $to_date = get_date();
            }

            //add news
            $where = [
                'published' => STATUS_ON,
                'publish_date >=' => $from_date,
                'publish_date <=' => $to_date,
            ];

            //reset table
            $this->model->setTableNameYear(strtotime($from_date));

            $news_list = $this->model
                ->select('news_id, slug, name, tags, meta_keyword, publish_date, created_at, updated_at')
                ->orderBy('news_id', 'desc')
                ->where($where)
                ->findAll();

            if (!empty($news_list)) {
                foreach ($news_list as $key => $value) {
                    $value = $this->model->formatDetail($value);

                    $data_news = [
                        'publication' => ['name' => config_item('site_name'), 'language' => 'vi'],
                        'publication_date' => date('Y-m-d\TH:i:sP', strtotime($value['publish_date'])),
                        'title' => $this->_utf8ForXml(htmlspecialchars($value['name'])),
                        'keywords' => !empty($value['meta_keyword']) ? $this->_utf8ForXml(htmlspecialchars($value['meta_keyword'])) : $value['tags'],
                    ];

                    $this->libsitemap->add(base_url($value['detail_url']), null, null, null, $data_news);
                }
            }

            $x = $this->libsitemap->output('urlset', 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"');

            $this->response
                ->setXML($x)
                ->send();
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            page_not_found();
        }
    }

    public function category()
    {
        try {
            $category_model = new CategoryModel();
            $category_list = $category_model->getNewsCategories(language_id());

            $changefreq = 'daily';
            $priority = '1.0';

            //add home
            $this->libsitemap->add(base_url(), date('Y-m-d\TH:i:sP', time()), $changefreq, $priority);

            //add category
            if (!empty($category_list)) {
                foreach ($category_list as $value) {
                    $this->libsitemap->add(base_url($value['slug']), date('Y-m-d\TH:i:sP', strtotime($value['updated_at'])), $changefreq, $priority);
                }
            }

            $x = $this->libsitemap->output('urlset', 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"');

            $this->response
                ->setXML($x)
                ->send();
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            page_not_found();
        }
    }

    public function post($year = null)
    {
        try {
            $post_model = new \App\Modules\Posts\Models\PostModel();

            if (empty($year)) {
                $year = date('Y', time());
            }

            $from_date = date('Y-01-01 00:00:00', strtotime($year));
            $to_date = date('Y-12-t 23:59:59', strtotime($year));

            //add news
            $where = [
                'published' => STATUS_ON,
                'publish_date >=' => $from_date,
                'publish_date <=' => $to_date,
            ];

            $post_list = $post_model->select('post_id, slug, name, tags, meta_keyword, publish_date, created_at, updated_at')
                ->orderBy('post_id', 'desc')
                ->where($where)
                ->findAll();

            if (!empty($post_list)) {
                foreach ($post_list as $key => $value) {
                    $value = $post_model->formatDetail($value);

                    $data_news = [
                        'publication' => ['name' => config_item('site_name'), 'language' => 'vi'],
                        'publication_date' => date('Y-m-d\TH:i:sP', strtotime($value['publish_date'])),
                        'title' => $this->_utf8ForXml(htmlspecialchars($value['name'])),
                        'keywords' => !empty($value['meta_keyword']) ? $this->_utf8ForXml(htmlspecialchars($value['meta_keyword'])) : $value['tags'],
                    ];

                    $this->libsitemap->add(base_url($value['detail_url']), null, null, null, $data_news);
                }
            }

            $x = $this->libsitemap->output('urlset', 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"');

            $this->response
                ->setXML($x)
                ->send();
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            page_not_found();
        }
    }

    private function _utf8ForXml($string)
    {
        return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}
