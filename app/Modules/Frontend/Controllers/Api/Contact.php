<?php namespace App\Modules\Frontend\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use App\Controllers\MyController;

class Contact extends MyController
{
    use ResponseTrait;

    public function index()
    {
        // if (!$this->request->isAJAX()) {
        //     return $this->failNotFound(lang('Contact.text_contact'));
        // }
        
        $data = [
            'contact' => lang('Contact.text_contact'),
            'title' => lang('Contact.text_title'),
            'email' => lang('Contact.text_email'),
            'name' => lang('Contact.text_name'),
            'message' => lang('Contact.text_message'),
            'location' => lang('Contact.text_location'),
            'google_map' => lang('Contact.text_google_map'),
            'google_map' => lang('Contact.text_google_map'),
        ];

        $params = [
            'breadcrumbs' => service('breadcrumb')->get(),
            'breadcrumb_title' => lang('Contact.text_title'),
            'module' => 'frontend/contact',// su dung de load template layout cho trang
        ];

        $data['layouts'] = service("react")->getTemplate(($params));
        
        return $this->setResponseFormat('json')->respond($data, 200);
    }
}
