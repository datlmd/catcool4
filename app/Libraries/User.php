<?php

namespace App\Libraries;

class User
{
    /**
     * @var int|mixed
     */
    private int $_user_id = 0;

    /**
     * @var string|mixed
     */
    private string $_firstname = '';

    /**
     * @var string|mixed
     */
    private string $_lastname = '';

    /**
     * @var string|mixed
     */

    private string $_email = '';

    /**
     * @var string|mixed
     */
    private string $_telephone = '';

    private array $_user_info = [];

    private array $_errors = [];

    private string $_image = '';

    private array $_permission = [];

    private bool $_super_admin = false;

    private string $_username = '';

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        if (!empty(session('user_info.user_id'))) {
            $user_model = new \App\Modules\Users\Models\UserModel();

            $user_info = $this->getUserInfo();
            if (!empty($user_info)) {
                $update = [
                    'language_id' => language_id_admin(),
                    'ip'          => service('request')->getIPAddress(),
                ];

                $user_model->update($user_info['user_id'], $update);

            } else {
                $this->logout();
            }
        }
    }

    /**
     * Get Customer Info
     *
     * @return   array
     */
    public function getUserInfo(): array
    {
        if (!empty($this->_user_info)) {
            return $this->_user_info;
        }

        $user_model = new \App\Modules\Users\Models\UserModel();
        $this->_user_info = $user_model->getUserInfo(session('user_info.user_id'));
        if (empty($this->_user_info)) {
            return [];
        }

        $this->_user_id     = $this->_user_info['user_id'];
        $this->_firstname   = $this->_user_info['first_name'];
        $this->_lastname    = $this->_user_info['last_name'];
        $this->_username    = $this->_user_info['username'];
        $this->_email       = $this->_user_info['email'];
        $this->_telephone   = $this->_user_info['phone'];
        $this->_super_admin = $this->_user_info['super_admin'];

        return $this->_user_info;
    }

    public function login(string $username, string $password, bool $remember = false): bool
    {
        $user_model = new \App\Modules\Users\Models\UserModel();
        if (!$user_model->login($username, $password, $remember)) {
            $this->_errors = $user_model->getErrors();
            return false;
        }

        $user_info = $this->getUserInfo();

        $language_list = list_language_admin();
        if (is_multi_language() && !empty($language_list[$user_info['language_id']])) {
            set_language_admin($language_list[$user_info['language_id']]['code']);
        }

        return true;
    }

    public function loginRememberedUser(): bool
    {
        $user_model = new \App\Modules\Users\Models\UserModel();

        if (!$user_model->loginRememberedUser()) {
            $this->_errors = $user_model->getErrors();
            return false;
        }

        $user_info = $this->getUserInfo();

        $language_list = list_language_admin();
        if (is_multi_language() && !empty($language_list[$user_info['language_id']])) {
            set_language_admin($language_list[$user_info['language_id']]['code']);
        }

        return true;
    }

    /**
     * Logout
     *
     * @return   void
     */
    public function logout(): void
    {
        $user_model = new \App\Modules\Users\Models\UserModel();
        $user_model->logout();

        $this->_user_info = [];

        $this->_user_id = 0;
        $this->_firstname = '';
        $this->_lastname = '';
        $this->_email = '';
        $this->_telephone = '';
        $this->_image = '';
        $this->_super_admin = false;
    }

    public function getErrors(): array
    {
        return $this->_errors;
    }

    public function getSuperAdmin(): bool
    {
        return $this->_super_admin;
    }

    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * isLogged
     *
     * @return   bool
     */
    public function isLogged(): bool
    {
        return $this->_user_id ? true : false;
    }

    /**
     * getId
     *
     * @return   int
     */
    public function getId(): int
    {
        return $this->_user_id;
    }

    /**
     * getFirstName
     *
     * @return   string
     */
    public function getFirstName(): string
    {
        return $this->_firstname;
    }

    /**
     * getLastName
     *
     * @return   string
     */
    public function getLastName(): string
    {
        return $this->_lastname;
    }

    /**
     * getEmail
     *
     * @return   string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * getTelephone
     *
     * @return   string
     */
    public function getTelephone(): string
    {
        return $this->_telephone;
    }

    public function getImage(): string
    {
        return $this->_image;
    }
}
