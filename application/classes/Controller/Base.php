<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Base extends Controller_Template
{

    /**
     * Auto loading configs groups
     *
     * @var array
     */
    public $config_groups = array(
        'blog',
    );

    /**
     * Auto loaded configs
     *     Format:
     *         array (group => params)
     *
     * @var array
     */
    public $config = array();

    public $template = "layout";

    public function _proccessMessages()
    {
        $result = array();
        $succ  = array();
        $err   = array();

        $success = Notice::as_array( Notice::SUCCESS );
        if( array_key_exists('success', $success) )
        {
            if( count($success['success']) )
            {
                foreach( $success['success'] as $msg )
                {
                    $succ[] = $msg['message'];
                }
            }
        }
        $succ = implode(', ', $succ);

        $result['success'] = $succ;

        $error = Notice::as_array( Notice::ERROR );
        if( array_key_exists('error', $error) )
        {
            if( count($error['error']) )
            {
                foreach( $error['error'] as $msg )
                {
                    $err[] = $msg['message'];
                }

            }
        }
        $err = implode(', ', $err);
        $result['error'] = $err;

        Notice::clear();
        return $result;
    }

    public function before()
    {
        parent::before();
        $this->template->system_msg = $this->_proccessMessages();
        $this->template->content = '';
        $this->template->base_url = URL::base( $this->request );
    }
}