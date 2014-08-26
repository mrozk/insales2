<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Layout extends Controller_Base
{
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
    public $login_url = 'admin/auth/login';

    /**
     * Roles
     *
     * @var array
     */
    public $roles = array('login', 'admin');


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
            $this->redirect( URL::base( $this->request ) .  $this->login_url);
            //$this->request->redirect($this->login_url);
        }

        // set template variables
        $this->template->set_global('user', $this->user);
    }
}
