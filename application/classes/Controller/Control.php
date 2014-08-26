<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Control extends Controller {



    public function action_index()
    {
    }

    public function action_install()
    {
        $token = $this->request->query('token');
        $shop = $this->request->query('shop');
        $insales_id = (int)$this->request->query('insales_id');
        if( $token && $shop && $insales_id )
        {

            $password = md5( $token . InsalesApi::$secret_key );
            $insales_user = ORM::factory('InsalesUser', array('insales_id' => $insales_id));
            if( !$insales_user->loaded() )
            {
                $insales_user->token = $token;
                $insales_user->shop = $shop;
                $insales_user->insales_id = $insales_id;
                $insales_user->passwd = $password;
                $insales_user->save();
                // $this->addNewShipping( $insales_user->shop, $insales_user->passwd );
            }
            else
            {
                $this->response->body('record already exists');
            }
        }
        else
        {
            $this->response->body('bad params');
        }
    }

    public function action_uninstall()
    {
        $token = $this->request->query('token');
        $shop = $this->request->query('shop');
        $insales_id = (int)$this->request->query('insales_id');
        $insales_user = ORM::factory('InsalesUser', array( 'insales_id' => $insales_id, 'passwd' => $token ));
        if( $insales_user->loaded() )
        {
            $insales_user->delete();
        }
    }
} 