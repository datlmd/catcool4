<?php namespace App\Modules\News\Controllers;

use CodeIgniter\Controller;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

use App\Libraries\LibSitemap;

class Sitemap extends Controller
{
    protected $model;

    protected $helpers = ['url','date', 'catcool', 'inflector'];

    public function __construct()
    {
        $this->model = new NewsModel();

        $this->libsitemap = new LibSitemap();

        date_default_timezone_set('Asia/Saigon');
    }

    public function index()
    {
        $this->libsitemap->add(base_url('sitemap-category.xml'), date('c', time()));
        $this->libsitemap->add(base_url('sitemap-news.xml'), date('c', time()));

        $x = $this->libsitemap->output('sitemapindex', 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"');

        $this->response
            ->setXML($x)
            ->send();
    }

    public function news()
    {
        //add news
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];
        $news_list = $this->model
            ->select('news_id, slug, name, tags, meta_keyword, publish_date, ctime, mtime')
            ->orderBy('news_id', 'desc')
            ->where($where)
            ->findAll();

        if (!empty($news_list))
        {
            foreach ($news_list as $key => $value) {
                $value = $this->model->formatDetail($value);

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
    }

    public function category()
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getListPublished();

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
    }

    private function _utf8ForXml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}
