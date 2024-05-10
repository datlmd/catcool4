<?php namespace App\Libraries;

class Customer
{
	/**
	 * @var int|mixed
	 */
	private int $_customer_id = 0;
	/**
	 * @var string|mixed
	 */
	private string $_firstname = '';
	/**
	 * @var string|mixed
	 */
	private string $_lastname = '';
	/**
	 * @var int|mixed
	 */
	private int $_customer_group_id = 0;
	/**
	 * @var string|mixed
	 */
	private string $_email = '';
	/**
	 * @var string|mixed
	 */
	private string $_telephone = '';
	/**
	 * @var bool|mixed
	 */
	private bool $_newsletter = false;

    private array $_customer_info = [];

    private array $_errors = [];

	private string $_image = '';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
    {
		if (!empty(session('customer.customer_id'))) {
            $customer_model = new \App\Modules\Customers\Models\CustomerModel();
			
			$customer_info = $this->getCustomerInfo();
			if (!empty($customer_info)) {
                $update = [
                    'language_id' => get_lang_id(),
                    'ip'          => service('request')->getIPAddress(),
                ];
        
                $customer_model->update($customer_info['customer_id'], $update);

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
    public function getCustomerInfo(): array {
        if (!empty($this->_customer_info)) {
            return $this->_customer_info;
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();
        $this->_customer_info = $customer_model->getCustomerInfo(session('customer.customer_id'));
        if (empty($this->_customer_info)) {
            return [];
        }

        $this->_customer_id       = $this->_customer_info['customer_id'];
        $this->_firstname         = $this->_customer_info['first_name'];
        $this->_lastname          = $this->_customer_info['last_name'];
        $this->_customer_group_id = $this->_customer_info['group_id'];
        $this->_email             = $this->_customer_info['email'];
        $this->_telephone         = $this->_customer_info['phone'];
        $this->_newsletter        = $this->_customer_info['newsletter'];
		$this->_image       	  = $customer_model->getAvatar($this->_customer_info['image']);

        return $this->_customer_info;
    }
	
    public function login(string $username, string $password, bool $remember = false): bool {
        $customer_model = new \App\Modules\Customers\Models\CustomerModel();
        if (!$customer_model->login($username, $password, $remember)) {
            $this->_errors = $customer_model->getErrors();
            return false; 
        }

        $customer_info = $this->getCustomerInfo();

        $language_list = get_list_lang();
        if (is_multi_lang() && !empty($language_list[$customer_info['language_id']])) {
            set_lang($language_list[$customer_info['language_id']]['code']);
        }

        return true;
    }

    public function loginRememberedCustomer(): bool {
        $customer_model = new \App\Modules\Customers\Models\CustomerModel();
        
        if (!$customer_model->loginRememberedCustomer()) {
            $this->_errors = $customer_model->getErrors();
            return false;
        }

        $customer_info = $this->getCustomerInfo();

        $language_list = get_list_lang();
        if (is_multi_lang() && !empty($language_list[$customer_info['language_id']])) {
            set_lang($language_list[$customer_info['language_id']]['code']);
        }

        return true;
    }

    public function loginSocial(string $social_type, array $data): bool {
        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        if (!$customer_model->loginSocial($social_type, $data)) {
            $this->_errors = $customer_model->getErrors();
            return false;
        }

        $customer_info = $this->getCustomerInfo();

        $language_list = get_list_lang();
        if (is_multi_lang() && !empty($language_list[$customer_info['language_id']])) {
            set_lang($language_list[$customer_info['language_id']]['code']);
        }

        return true;
    }

	/**
	 * Logout
	 *
	 * @return   void
	 */
	public function logout(): void {
        $customer_model = new \App\Modules\Customers\Models\CustomerModel();
		$customer_model->logout();

        $this->_customer_info = [];

		$this->_customer_id = 0;
		$this->_firstname = '';
		$this->_lastname = '';
		$this->_customer_group_id = 0;
		$this->_email = '';
		$this->_telephone = '';
		$this->_image = '';
		$this->_newsletter = false;
	}

    public function getErrors(): array {
        return $this->_errors;
    }

	/**
	 * isLogged
	 *
	 * @return   bool
	 */
	public function isLogged(): bool {
		return $this->_customer_id ? true : false;
	}

	/**
	 * getId
	 *
	 * @return   int
	 */
	public function getId(): int {
		return $this->_customer_id;
	}
	
	/**
	 * getFirstName
	 *
	 * @return   string
	 */
	public function getFirstName(): string {
		return $this->_firstname;
	}

	/**
	 * getLastName
	 *
	 * @return   string
	 */
	public function getLastName(): string {
		return $this->_lastname;
	}
	
	/**
	 * getGroupId
	 *
	 * @return   int
	 */
	public function getGroupId(): int {
		return $this->_customer_group_id;
	}
	
	/**
	 * getEmail
	 *
	 * @return   string
	 */
	public function getEmail(): string {
		return $this->_email;
	}

	/**
	 * getTelephone
	 *
	 * @return   string
	 */
	public function getTelephone(): string {
		return $this->_telephone;
	}

	/**
	 * getNewsletter
	 *
	 * @return   bool
	 */
	public function getNewsletter(): bool {
		return $this->_newsletter;
	}

	public function getImage(): string {
		return $this->_image;
	}

	/**
	 * getAddressId
	 *
	 * @return   int
	 */
	public function getAddressId(): int {

        // address
        $address_model = model('App\Modules\Customers\Models\AddressModel');
        $address_info = $address_model->where([
            'customer_id' => (int)$this->_customer_id,
            'default' => '1'
            ])->first();

		if (empty($address_info)) {
			return 0;
		}

        return (int)$address_info['address_id'];
	}
	
	/**
	 * getBalance
	 *
	 * @return   float
	 */
	public function getBalance(): float {
		//$query = $this->db->query("SELECT SUM(`amount`) AS `total` FROM `" . DB_PREFIX . "customer_transaction` WHERE `customer_id` = '" . (int)$this->_customer_id . "'");

		//return (float)$query->row['total'];
	}

	/**
	 * getRewardPoints
	 *
	 * @return   float
	 */
	public function getRewardPoints(): float {
		//$query = $this->db->query("SELECT SUM(`points`) AS `total` FROM `" . DB_PREFIX . "customer_reward` WHERE `customer_id` = '" . (int)$this->_customer_id . "'");

		//return (float)$query->row['total'];
	}
}
