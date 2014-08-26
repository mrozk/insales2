<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Layout_Default extends Controller_Template {

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

    /**
     * Default layout template
     *
     * @var View
     */
    public $template = 'layout';

    /**
     * Before execute action
     */
    public function before()
    {
        parent::before();

        // load configs
        foreach ($this->config_groups as $group)
        {
            $this->config[$group] = Kohana::$config->load($group)->as_array();
        }

        // bind this value as global for all templates
        View::set_global('config', $this->config);

        // bind as global value session message if exists
        View::set_global('message', Session::instance()->get_once('message'));
    }

} // End Layout Default Controller
