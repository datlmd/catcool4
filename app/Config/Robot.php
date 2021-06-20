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
				'id'    => [2],
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
