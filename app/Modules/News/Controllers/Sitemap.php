<?php namespace App\Modules\News\Controllers;

use CodeIgniter\Controller;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

use App\Libraries\LibSitemap;

class Sitemap extends Controller
{
    protected $model;

    protected $helpers = ['url','date', 'catcool'];

    public function __construct()
    {

        $this->model = new NewsModel();

        $this->libsitemap = new LibSitemap();
    }

    public function index()
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getListPublished();

        $changefreq = 'daily';
        $priority = '1.0';

        //add home
        $this->libsitemap->add(base_url(), date('c', now()), $changefreq, $priority);

        //add category
        if (!empty($category_list)) {
            $changefreq = null;
            $priority = '0.9';
            foreach ($category_list as $value) {
                $this->libsitemap->add(base_url($value['slug']), date('c', strtotime($value['mtime'])), $changefreq, $priority);
            }
        }

        //add news
        $where = [
            'published' => STATUS_ON,
            'publish_date <=' => get_date(),
        ];
        $news_list = $this->model->select('news_id, slug, ctime, mtime')->where($where)->findAll();
        if (!empty($news_list))
        {
            $changefreq = null;
            $priority = '0.8';
            foreach ($news_list as $key => $value) {
                $value = $this->model->formatDetail($value);
                $this->libsitemap->add(base_url($value['detail_url']), date('c', strtotime($value['mtime'])), $changefreq, $priority);
            }
        }

        $x = $this->libsitemap->output();

        $this->response
            ->setXML($x)
            ->send();
    }
}
