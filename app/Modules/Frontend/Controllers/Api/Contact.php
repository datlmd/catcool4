<?php namespace App\Modules\Frontend\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Contact extends Controller
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->request->isAJAX()) {
            return $this->failNotFound(lang('Contact.text_contact'));
        }
        
        $lang = [
            'contact' => lang('Contact.text_contact'),
            'title' => lang('Contact.text_title'),
            'email' => lang('Contact.text_email'),
            'name' => lang('Contact.text_name'),
            'message' => lang('Contact.text_message'),
            'location' => lang('Contact.text_location'),
            'google_map' => lang('Contact.text_google_map'),
            'google_map' => lang('Contact.text_google_map'),
        ];

        $data = [
            'lang' => $lang,
        ];
        
        return $this->setResponseFormat('json')->respond($data, 200);
    }
}
