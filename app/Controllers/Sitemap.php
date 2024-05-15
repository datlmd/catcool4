<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\LibSitemap;

class Sitemap extends Controller
{
    protected $model;

    protected $helpers = ['url','date', 'catcool', 'inflector', 'cookie'];

    const SITEMAP_NEWS_FROM = '2024-01-01';

    public function __construct()
    {
        $this->libsitemap = new LibSitemap();

        date_default_timezone_set('Asia/Saigon');
    }

    public function index()
    {
        try {
            $this->libsitemap->add(base_url('sitemap-category.xml'), date('c', time()));

            $post_start = strtotime(self::SITEMAP_NEWS_FROM);
            $post_end = time();
            while ($post_end > $post_start) {

                $new_year = sprintf('sitemap-post-%s.xml', date('Y', $post_end));
                $this->libsitemap->add(base_url($new_year), date('c', time()));

                $post_end = strtotime("-1 year", $post_end);
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

    public function category()
    {
        try {
            $post_category_model = new \App\Modules\Posts\Models\CategoryModel();
            $category_list = $post_category_model->getPostCategories(language_id());

            $changefreq = 'daily';
            $priority = '1.0';

            //add home
            $this->libsitemap->add(base_url(), date('Y-m-d\TH:i:sP', time()), $changefreq, $priority);

            //add category
            if (!empty($category_list)) {
                foreach ($category_list as $value) {
                    $this->libsitemap->add(base_url($value['slug']), date('Y-m-d\TH:i:sP', strtotime($value['mtime'])), $changefreq, $priority);
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

            $post_list = $post_model->select('post_id, slug, name, tags, meta_keyword, publish_date, ctime, mtime')
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
                        'keywords' => !empty($value['meta_keyword']) ? $this->_utf8ForXml(htmlspecialchars($value['meta_keyword'])) : $value['tags']
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
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}
