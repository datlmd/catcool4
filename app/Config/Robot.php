<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Robot extends BaseConfig
{

	public $pageKenh14 = [
		'domain'     => 'Kênh 14',
		'domain_id'  => 1,
		'url_domain' => 'https://kenh14.vn/',
		'slide_home' => [0,2,4],

		'attribute_menu' => [
			[
				'href'  => 'https://kenh14.vn/star.chn',
				'title' => 'Sao',
				'id'    => [1],
			],
			[
				'href'  => 'https://kenh14.vn/cine.chn',
				'title' => 'Phim',
				'id'    => [2],
			],
			[
				'href'  => 'https://kenh14.vn/musik.chn',
				'title' => 'Nhac',
				'id'    => [3],
			],
			[
				'href'  => 'https://kenh14.vn/beauty-fashion.chn',
				'title' => 'Thời trang',
				'id'    => [4],
			],
			[
				'href'  => 'https://kenh14.vn/suc-khoe-gioi-tinh.chn',
				'title' => 'Gioi tinh',
				'id'    => [5],
			],
			[
				'href'  => 'https://kenh14.vn/sport.chn',
				'title' => 'The thao',
				'id'    => [6],
			],
			[
				'href'  => 'https://kenh14.vn/xa-hoi.chn',
				'title' => 'Xa hoi',
				'id'    => [7],
			],
			[
				'href'  => 'https://kenh14.vn/the-gioi.chn',
				'title' => 'The gioi',
				'id'    => [8],
			],
			[
				'href'  => 'https://kenh14.vn/2-tek.chn',
				'title' => 'Công nghệ',
				'id'    => [9],
			],
			[
				'href'  => 'https://kenh14.vn/hoc-duong.chn',
				'title' => 'Hoc duong',
				'id'    => [10],
			],
		],

		'attribute_cate' => [
			'attribute_cate_1' => [
				'start' => 'li class="ktncli"',
				'end'   => '</li',
				'title' => '/title=\"(.*?)\"/',
				'note'  => '/span class=\"ktncli-sapo\">(.*?)</',
				//'datetime' => '/span class=\"kscliw-time\"(.*?)title=\"(.*?)\"/',
				'image' => '/src=\"(.*?)\"/',
				'href'  => '/href=\"(.*?)\"/',
			],
			'attribute_cate_2' => [
				'start' => 'knswli-left fl',
				'end'   => '</li',
				'title' => '/title=\'(.*?)\'/',
				//'note'  => '/class=\'knswli-sapo sapo-need-trim\'>(.*?)</',
				'note'  => 'span.knswli-sapo',
				//'datetime' => '/span class=\'kscliw-time\'(.*?)title=\'(.*?)\'/',
				'image' => '/src=\"(.*?)\"/',
				'href'  => '/href=\'(.*?)\'/',
			],
		],

		'attribute_detail' => [
			'attribute_detail_1' => [
				'title'    => '',
				'note'     => '',
				'content'  => 'div.knc-content',
				'datetime' => '',
				'author'   => '',
			],
		],

		'attribute_remove' => [
			'list_in_detail' => '/listNewsLink-wrapper\">(.*?)\<\/div/',
		],

		'attribute_meta' => [
			'description' => '/name=\"description\" content=\"(.*?)\"/',
			'keywords'	  => '/name=\"keywords\" content=\"(.*?)\"/',
			'image_fb'    => '/property=\"og:image\" content=\"(.*?)\"/',
		],

		'attribute_tags' => [
			'start' => 'li class="kli',
			'end' => '/li',
			'tag' => '/title=\"(.*?)\"/',
		],
	];
}
