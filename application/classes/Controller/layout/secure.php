<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Layout_Secure extends Controller_Layout_Default {

    /**
     * @var Kohana_Auth_ORM
     */
    public $auth = NULL;

    /**
     * @var Model_User
     */
    public $user = NULL;

    /**
     * Login page URL
     *
     * @var string
     */
    public $login_url = 'login';

    /**
     * Roles
     *
     * @var array
     */
    public $roles = array('login');

    /**
     * Before execute action
     */
    public function before()
    {
        parent::before();

        // auth
        $this->auth = Auth::instance();

        // user
        $this->user = $this->auth->get_user();

        // check access
        if (is_array($this->roles) AND !(empty($this->roles)) AND ! $this->auth->logged_in($this->roles) )
        {
            $this->request->redirect($this->login_url);
        }

        // set template variables
        $this->template->set_global('user', $this->user);
    }

} // End Layout Secure Controller